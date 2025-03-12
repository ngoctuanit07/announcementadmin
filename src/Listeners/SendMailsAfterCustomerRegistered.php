<?php

namespace Botble\Announcementadmin\Listeners;

use Botble\Base\Facades\EmailHandler;
use Botble\Ecommerce\Facades\EcommerceHelper;
use Botble\Ecommerce\Models\Customer;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Log;
class SendMailsAfterCustomerRegistered
{
    public function handle(Registered $event): void
    {
        $customer = $event->user;
          // Log the $customer variable
        //  Log::info('Customer registered:', ['customer' => $customer]);

        if (! $customer instanceof Customer) {
            return;
        }

        EmailHandler::setModule(ANNOUNCEMENTADMIN_MODULE_SCREEN_NAME)
        ->setVariableValues([
            'announcementadmin_email' => $customer->email,
        ])
        ->sendUsingTemplate('announcementadmin_admin_email', setting('email_template_email_contact', get_admin_email()->first() ?: 'demo@example.com'));
    }
}
