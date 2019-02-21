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

    public function __construct
    (
        \Magento\Customer\Model\AccountManagementFactory    $accountManagementFactory,
        \Magento\Customer\Api\Data\CustomerInterfaceFactory $customer,
        CustomerTokenFactory                                $customerToken,
        \Magento\Customer\Model\AddressFactory              $addressFactory
    )
    {
        $this->_accountManagementFactory  = $accountManagementFactory;
        $this->_customerInterfaceFactory  = $customer;
        $this->_customerTokenFactory      = $customerToken;
        $this->_addressFactory            = $addressFactory;
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

        $addressData        = $this->_setCustomerAddressData($customerData['addresses']);
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
        $address = $this->_addressFactory->create();

        foreach($addressData as $data){
            $address->setDefaultShipping($data['defaultShipping']);
            $address->setDefaultBilling($data['defaultBilling']);
            $address->setFirstName($data['firstname']);
            $address->setLastName($data['lastname']);
            $address->setRegionCode($data['region']['regionCode']);
            $address->setRegione($data['region']['region']);
            $address->setRegionId($data['region']['regionId']);
            $address->setPostcode($data['postcode']);
            $address->setStreet($data['street'][0]);
            $address->setCity($data['city']);
            $address->setTelephone($data['telephone']);
            $address->setCountryId($data['countryId']);
        }

        return $address;
    }

}