<?php

namespace App\Console\Commands;

use App\Models\ArticleView;
use App\Models\Comment;
use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Mail;

class SendDailySiteStats extends Command
{
    protected $signature = 'site:daily-stats {--send : Send the report once today to moderator email addresses} {--to= : Send a one-off copy to this address without consuming the daily guard}';
    protected $description = 'Show or email today’s article views and new comments';

    public function handle(): int
    {
        $today = now()->startOfDay();
        $views = ArticleView::where('viewed_at', '>=', $today)->count();
        $comments = Comment::where('created_at', '>=', $today)->count();
        $report = "Статистика сайта за ".$today->format('d.m.Y')."\nПросмотры статей: {$views}\nНовые комментарии: {$comments}";
        $this->line($report);

        if (!$this->option('send')) {
            $this->comment('Письмо не отправлено. Для отправки используйте --send.');
            return self::SUCCESS;
        }

        $testRecipient = $this->option('to');

        if ($testRecipient !== null) {
            if (!filter_var($testRecipient, FILTER_VALIDATE_EMAIL)) {
                $this->error('Укажите корректный адрес электронной почты в параметре --to.');
                return self::FAILURE;
            }

            $recipients = [$testRecipient];
        } else {
            if (!Cache::add('site:daily-stats:sent:'.$today->toDateString(), true, now()->endOfDay())) {
                $this->info('Статистика за сегодня уже отправлялась.');
                return self::SUCCESS;
            }

            $recipients = User::where('role_id', 1)->pluck('email')->filter()->all();
            if (!$recipients) {
                Cache::forget('site:daily-stats:sent:'.$today->toDateString());
                $this->warn('У модераторов не указаны адреса email.');
                return self::SUCCESS;
            }
        }

        foreach ($recipients as $email) {
            Mail::raw($report, function ($message) use ($email) {
                $message->to($email)->subject('Статистика сайта за день');
            });
        }
        $this->info($testRecipient !== null
            ? 'Проверочный отчёт отправлен на указанный адрес.'
            : 'Отчёт отправлен модераторам.');
        return self::SUCCESS;
    }
}
