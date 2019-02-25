<?php
/**
 * NOTICE OF LICENSE
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade Magento to newer
 * versions in the future.
 *
 * @copyright Copyright (c) 2019 ThdSolution
 *
 * @author    Tiago Daniel <tiagohdaniel@gmail.com>
 */

namespace ThdSolution\OrderApi\Model;


class PaymentInformationManagement
{
    /**
     * @var \Magento\Checkout\Api\PaymentInformationManagementInterfaceFactory
     */
    private $_paymentInformationManagement;

    /**
     * @var \Magento\Quote\Api\Data\PaymentInterfaceFactory
     */
    private $_paymentInterface;

    /**
     * @var \Magento\Quote\Api\Data\AddressInterfaceFactory
     */
    private $addressInterface;

    public function __construct
    (
        \Magento\Checkout\Api\PaymentInformationManagementInterfaceFactory $paymentInformationManagement,
        \Magento\Quote\Api\Data\PaymentInterfaceFactory                    $paymentInterface,
        \Magento\Quote\Api\Data\AddressInterfaceFactory                    $addressInterface
    )
    {
        $this->_paymentInformationManagement = $paymentInformationManagement;
        $this->_paymentInterface             = $paymentInterface;
    }

    public function savePaymentInformationAndPlaceOrder($cartId, $paymentMethod, $billingAddress = null)
    {
        /** @var  $paymentInterfaceFactory */
        $paymentInterfaceFactory             = $this->_paymentInterface->create();
        $paymentInterfaceFactory->setMethod($paymentMethod['method']);

        /** @var  $paymentInformationManagementFactory */
        $paymentInformationManagementFactory = $this->_paymentInformationManagement->create();

        $result                              = $paymentInformationManagementFactory->savePaymentInformationAndPlaceOrder(
                                                $cartId, $paymentInterfaceFactory, $billingAddress);

        return $result;
    }

}