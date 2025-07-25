<?php

namespace App\Tests\Api\Payment;

use ApiPlatform\Symfony\Bundle\Test\ApiTestCase;
use App\Entity\Payment;
use App\Enum\PaymentStatusEnum;
use App\Repository\PaymentRepository;
use Exception;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;

class CheckoutEventControllerTest extends ApiTestCase
{
    /**
     * @throws TransportExceptionInterface
     * @throws Exception
     */
    public function testValidPaymentCheckout(): void
    {
        $payment = static::getContainer()->get(PaymentRepository::class)->find('01d03d58-223b-11ee-8c90-7a506f18fbbd');
        static::assertInstanceOf(Payment::class, $payment);
        static::assertSame(PaymentStatusEnum::unpaid, $payment->getStatus());

        static::createClient()->request(Request::METHOD_POST, '/api/payment/checkout-event', [
            'body' => '{"id":"evt_1NTiF2D9ydGMS1miynTgTvgm","object":"event","api_version":"2022-11-15","created":1689326688,"data":{"object":{"id":"cs_test_a1mDrpf6pNz5se6r7HHbw9phbLyjbPCIs4wd6pURL8ocXQWaDotrf4OOzr","object":"checkout.session","after_expiration":null,"allow_promotion_codes":null,"amount_subtotal":1500,"amount_total":1500,"automatic_tax":{"enabled":false,"status":null},"billing_address_collection":null,"cancel_url":"https://may-english-tchai.vercel.app//payment-canceled/1ee22284-1285-684a-8ebf-d3722f89935d","client_reference_id":null,"consent":null,"consent_collection":null,"created":1689326678,"currency":"eur","currency_conversion":null,"custom_fields":[],"custom_text":{"shipping_address":null,"submit":null},"customer":null,"customer_creation":"if_required","customer_details":{"address":{"city":null,"country":"FR","line1":null,"line2":null,"postal_code":null,"state":null},"email":"mkl.devops@gmail.com","name":"Hamada Sidi","phone":null,"tax_exempt":"none","tax_ids":[]},"customer_email":null,"expires_at":1689413078,"invoice":null,"invoice_creation":{"enabled":false,"invoice_data":{"account_tax_ids":null,"custom_fields":null,"description":null,"footer":null,"metadata":{},"rendering_options":null}},"livemode":false,"locale":null,"metadata":{},"mode":"payment","payment_intent":"pi_3NTiF1D9ydGMS1mi1X6fH8E3","payment_link":null,"payment_method_collection":"always","payment_method_options":{},"payment_method_types":["card"],"payment_status":"paid","phone_number_collection":{"enabled":false},"recovered_from":null,"setup_intent":null,"shipping_address_collection":null,"shipping_cost":null,"shipping_details":null,"shipping_options":[],"status":"complete","submit_type":null,"subscription":null,"success_url":"https://may-english-tchai.vercel.app//payment-success/1ee22284-1285-684a-8ebf-d3722f89935d","total_details":{"amount_discount":0,"amount_shipping":0,"amount_tax":0},"url":null}},"livemode":false,"pending_webhooks":1,"request":{"id":null,"idempotency_key":null},"type":"checkout.session.completed"}',
        ]);
        static::assertResponseIsSuccessful();
        $payment = static::getContainer()->get(PaymentRepository::class)->find('01d03d58-223b-11ee-8c90-7a506f18fbbd');
        static::assertInstanceOf(Payment::class, $payment);
        static::assertSame(PaymentStatusEnum::paid, $payment->getStatus());
    }
}
