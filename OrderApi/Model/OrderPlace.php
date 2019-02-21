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

use Magento\Framework\Webapi\ServiceInputProcessor;
use Magento\Webapi\Controller\Rest;
use Magento\Framework\Webapi\Rest\Response\FieldsFilter;
use Magento\Framework\Webapi\Rest\Response as RestResponse;
use Magento\Framework\Webapi\ServiceOutputProcessor;

class OrderPlace
{
    /**
     * @var bodyparams
     */
    private $_bodyParams;

    /**
     * @var Rest\RequestFactory
     */
    private $_requestFactory;

    /**
     * @var ServiceInputProcessor
     */
    private $_serviceInputProcessor;

    /**
     * @var Rest\InputParamsResolverFactory
     */
    private $_rest;

    /**
     * @var FieldsFilter
     */
    private $_fieldsFilter;

    /**
     * @var RestResponse
     */
    private $_response;

    /**
     * @var ServiceOutputProcessor
     */
    private $_serviceOutputProcessor;

    /**
     * @var QuoteManagement
     */
    private $_quoteManagement;

    /**
     * @var CustomerFactory
     */
    private $_customer;

    public function __construct
    (
        \Magento\Framework\Webapi\Rest\RequestFactory       $requestFactory,
        ServiceInputProcessor                               $serviceInputProcessor,
        \Magento\Webapi\Controller\Rest\InputParamsResolver $rest,
        FieldsFilter                                        $fieldsFilter,
        RestResponse                                        $response,
        ServiceOutputProcessor                              $serviceOutputProcessor,
        QuoteManagementFactory                              $quoteManagement,
        CustomerFactory                                     $customer
    )
    {
        $this->_requestFactory            = $requestFactory;
        $this->_serviceInputProcessor     = $serviceInputProcessor;
        $this->_rest                      = $rest;
        $this->_fieldsFilter              = $fieldsFilter;
        $this->_response                  = $response;
        $this->_serviceOutputProcessor    = $serviceOutputProcessor;
        $this->_quoteManagement           = $quoteManagement;
        $this->_customer                  = $customer;
    }

    public function placeOrder()
    {
        $requestObj             =  $this->_requestFactory->create();
        $this->_bodyParams      = $requestObj->getBodyParams();

        /** @var  $customerFactory */
        $customerFactory        = $this->_customer->create();
        $customer               = $customerFactory->setCustomerData($this->_bodyParams['customer'], $this->_bodyParams['password']);

        /** @var  $quoteManagementFactory */
        $quoteManagementFactory = $this->_quoteManagement->create();

        $quoteId                = $quoteManagementFactory->createEmptyCartForCustomer($customer->getId());
        $quoteItemObj           = $quoteManagementFactory->addProducts($this->_bodyParams['cartItem'], $quoteId);
    }

}