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


class Customer
{
    /**
     * @var \Magento\Customer\Model\AccountManagementFactory
     */
    private $_accountManagementFactory;

    /**
     * @var \Magento\Customer\Model\AddressFactory
     */
    private $_addressFactory;

    /**
     * @var \Magento\Customer\Model\Data\RegionFactory
     */
    private $_regionFactory;

    public function __construct
    (
        \Magento\Customer\Model\AccountManagementFactory    $accountManagementFactory,
        \Magento\Customer\Api\Data\CustomerInterfaceFactory $customer,
        CustomerTokenFactory                                $customerToken,
        \Magento\Customer\Api\Data\AddressInterfaceFactory  $addressFactory,
        \Magento\Customer\Model\Data\RegionFactory          $region

    )
    {
        $this->_accountManagementFactory  = $accountManagementFactory;
        $this->_customerInterfaceFactory  = $customer;
        $this->_customerTokenFactory      = $customerToken;
        $this->_addressFactory            = $addressFactory;
        $this->_regionFactory             = $region;
    }

    /**
     * Setting customer data
     *
     * @param $customerData
     * @param $password
     * @return \Magento\Customer\Api\Data\CustomerInterface
     */
    public function setCustomerData($customerData, $password)
    {
        /** @var \Magento\Customer\Model\AccountManagement $accountManagement */
        $accountManagement  = $this->_accountManagementFactory->create();

        /** @var \Magento\Customer\Api\Data\CustomerInterfaceFactory $customer */
        $customer           = $this->_customerInterfaceFactory->create();

        $customer->setEmail($customerData['email']);
        $customer->setFirstname($customerData['firstname']);
        $customer->setLastname($customerData['lastname']);

        $addressData[]        = $this->_setCustomerAddressData($customerData['addresses']);
        $customer->setData('addresses', $addressData);
        $output             = $accountManagement->createAccount($customer, $password);

        /** @var  $customerToken */
        $customerToken      = $this->_customerTokenFactory->create();
        $token              = $customerToken->createCustomerAccessToken($customer->getEmail(), $password);

        return $output;
    }

    /**
     * Setting Address data for the customer
     *
     * @param $addressData
     * @return \Magento\Customer\Model\AddressFactory
     */
    private function _setCustomerAddressData($addressData)
    {
        /** @var \Magento\Customer\Model\AddressFactory $address */
        $address       = $this->_addressFactory->create();

        /** @var  $regionFactory */
        $regionFactory = $this->_regionFactory->create();

        foreach($addressData as $data){
            /*$address->setDefaultShipping($data['defaultShipping']);
            $address->setDefaultBilling($data['defaultBilling']);*/
            $address->setFirstName($data['firstname']);
            $address->setLastName($data['lastname']);
            $regionFactory->setRegionCode($data['region']['regionCode']);
            $regionFactory->setRegion($data['region']['region']);
            $regionFactory->setRegionId($data['region']['regionId']);
            $address->setRegion($regionFactory);
            $address->setPostcode($data['postcode']);
            $address->setStreet($data['street']);
            $address->setCity($data['city']);
            $address->setTelephone($data['telephone']);
            $address->setCountryId($data['countryId']);
        }

        return $address;
    }

}