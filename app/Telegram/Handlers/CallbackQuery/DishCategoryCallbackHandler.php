<?php

namespace App\Telegram\Handlers\CallbackQuery;

use App\Services\Cart\CartService;
use App\Services\Dots\Providers\DotsProvider;
use App\Telegram\Resolvers\TelegramMessageCartResolver;
use App\Telegram\Senders\CartSender;
use App\Telegram\Senders\TelegramSender;
use App\Telegram\Senders\DishCategorySender;
use Longman\TelegramBot\Entities\CallbackQuery;

class DishCategoryCallbackHandler
{
    /** @var TelegramSender */
    private $telegramSender;
    /** @var TelegramMessageCartResolver */
    private $telegramMessageCartResolver;
    /** @var DishCategorySender */
    private $dishCategorySender;
    /** @var CartSender */
    private $cartSender;
    /** @var CartService */
    private $cartService;

    /** @var DotsProvider */
    private $dotsProvider;

    public function __construct(
        TelegramSender $telegramSender,
        DishCategorySender $dishCategorySender,
        CartSender $cartSender,
        TelegramMessageCartResolver $telegramMessageCartResolver,
        CartService $cartService,
        DotsProvider $dotsProvider
    )
    {
        $this->telegramSender = $telegramSender;
        $this->dishCategorySender = $dishCategorySender;
        $this->cartSender = $cartSender;
        $this->telegramMessageCartResolver = $telegramMessageCartResolver;
        $this->cartService = $cartService;
        $this->dotsProvider = $dotsProvider;
    }

    public function handle(CallbackQuery $callbackQuery)
    {
        $message = $callbackQuery->getMessage();
        $chatId = $message->getChat()->getId();
        $data = $callbackQuery->getData();
        $data_arr = json_decode($data, true);
        $companyId = $data_arr['id'];
        $cart = $this->telegramMessageCartResolver->resolve($message);
        $cartCompanyId = $cart->getCompanyId();

        $data2 = [
            'chat_id' => $chatId,
            'text' => 'Company: '.$this->dotsProvider->getOneCompany($companyId)['name'],
        ];

        if($cartCompanyId != $companyId && $cart->getItems() != []){
            $Keyboard = $this->cartSender->getYesNoCityKeyboard();

            $data = [
                'chat_id' => $chatId,
                'text'    => trans('bots.requireChangeCompany'),
                'reply_markup' => $Keyboard,
            ];
            $this->telegramSender->sendData($data2);
            return $this->telegramSender->sendData($data);
        }
        $this->cartService->setCompanyId($cart, $companyId);

        $this->telegramSender->sendData($data2);
        return $this->dishCategorySender->send($chatId, $companyId);
    }

}
