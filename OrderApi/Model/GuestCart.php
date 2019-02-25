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

class GuestCart
{
    /**
     * @var \Magento\Quote\Model\GuestCart\GuestShippingMethodManagementFactory
     */
    private $_guestShippingMethodManagement;

    /**
     * @var \Magento\Quote\Model\Quote\AddressFactory
     */
    private $_addressFactory;

    /**
     * @var \Magento\Checkout\Api\Data\ShippingInformationInterface
     */
    private $_addressApi;

    public function __construct
    (
        \Magento\Checkout\Model\ShippingInformationManagementFactory   $guestShippingMethodManagement,
        \Magento\Quote\Model\Quote\AddressFactory                      $address,
        \Magento\Checkout\Api\Data\ShippingInformationInterfaceFactory $addressApi,
        \Magento\Quote\Api\Data\AddressInterfaceFactory                $addressInterface
    )
    {
        $this->_guestShippingMethodManagement = $guestShippingMethodManagement;
        $this->_addressFactory                = $address;
        $this->_addressApi                    = $addressApi;
        $this->_addressInterface              = $addressInterface;
    }

    /**
     * Get shipment estimation
     *
     * @param $cartId
     * @param AddressInterface $address
     * @return mixed
     */
    public function saveAddressInformation($cartId, $addressInformation)
    {
        /** @var  $guestShippingMethodManagementFactory */
        $guestShippingMethodManagementFactory = $this->_guestShippingMethodManagement->create();
        $addressApiFactory                    = $this->_addressApi->create();

        /** @var  $addressInterfaceFactory */
        $addressInterfaceFactory              = $this->_addressInterface->create();
        $addressInterfaceFactory->setData($addressInformation["shipping_address"]);
        $addressApiFactory->setShippingAddress($addressInterfaceFactory);

        /** @var  $addressInterfaceFactory creates another object to setup a billing address*/
        $addressInterfaceFactory              = $this->_addressInterface->create();
        $addressInterfaceFactory->setData($addressInformation["billing_address"]);
        $addressApiFactory->setBillingAddress($addressInterfaceFactory);

        $addressApiFactory->setShippingCarrierCode($addressInformation["shipping_carrier_code"]);
        $addressApiFactory->setShippingMethodCode($addressInformation["shipping_method_code"]);
        $shipmentData                         = $guestShippingMethodManagementFactory->saveAddressInformation($cartId, $addressApiFactory);

        return $addressApiFactory->getBillingAddress();
    }
}