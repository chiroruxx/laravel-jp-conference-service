<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use SendGrid;
use SendGrid\Mail\Content;
use SendGrid\Mail\From;
use SendGrid\Mail\Mail;
use SendGrid\Mail\Subject;
use SendGrid\Mail\To;

class UserController extends Controller
{
    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \LogicException
     */
    public function create()
    {
        return view('users.create');
    }

    /**
     * @param Request $request
     *
     * @return \Illuminate\Http\RedirectResponse
     * @throws \SendGrid\Mail\TypeException
     */
    public function store(Request $request)
    {
        $user = User::create($request->all());

        $from = new From('test@example.com');
        $to = new To($user->mail_address);
        $subject = new Subject('会員登録受付のお知らせ');
        $content = new Content('text/plain', '会員登録を受付ました。');

        $mail = new Mail($from, $to, $subject, $content);
        $response = (new SendGrid(config('services.sendgrid.key')))
            ->client->mail()->send()->post($mail);

        if ($response->statusCode() !== 202) {
            \Log::error('メールを送信できませんでした。');
        }

        return back()->with('success', '登録しました。');
    }
}
