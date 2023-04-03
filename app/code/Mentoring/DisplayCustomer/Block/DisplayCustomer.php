<?php

declare(strict_types=1);

namespace Mentoring\DisplayCustomer\Block;

use Magento\Backend\Block\Template\Context;
use Magento\Customer\Model\Context as ModelContext;
use Magento\Customer\Model\Session;
use Magento\Customer\Model\SessionFactory;
use Magento\Framework\App\Http\Context as HttpContext;
use Magento\Framework\View\Element\Template;


class DisplayCustomer extends Template
{
    public function __construct(
        protected HttpContext $httpContext,
        protected SessionFactory $customerSessionFactory,
        Context $context,
        array $data = []
    ) {
        parent::__construct($context, $data);
    }
    //c
    public function getCustomerName(): string
    {
        if ($this->httpContext->getValue(ModelContext::CONTEXT_AUTH)) {
            /** @var Session */
            $customerSession = $this->customerSessionFactory->create();
            return $customerSession->getCustomer()->getName() ?: '';
            // return (string)$this->httpContext->getValue(ModelContext::CONTEXT_AUTH);
        }

        return '';
    }
}
