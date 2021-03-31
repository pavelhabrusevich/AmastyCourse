<?php

namespace Amasty\AdditionalModule\Plugin;

class ChangeFormAction
{
    const ADD_TO_CART = 'checkout/cart/add';

    public function aroundGetFormAction($subject, $proceed)
    {
        return self::ADD_TO_CART;
    }
}
