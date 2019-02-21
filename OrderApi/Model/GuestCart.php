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
        \Magento\Checkout\Api\Data\ShippingInformationInterfaceFactory $addressApi
    )
    {
        $this->_guestShippingMethodManagement = $guestShippingMethodManagement;
        $this->_addressFactory                = $address;
        $this->_addressApi                    = $addressApi;
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
        $guestShippingMethodManagementFactory =  $this->_guestShippingMethodManagement->create();
        $addressApiFactory                    = $this->_addressApi->create();

        // set Shipping and billinfo address object in $addressInformation ()Magento\Quote\Model\Address
        //****************************************************
        $addressApiFactory->setData($addressInformation);

        $shipmentData                         = $guestShippingMethodManagementFactory->saveAddressInformation($cartId, $addressApiFactory);

        return $shipmentData;
    }
}