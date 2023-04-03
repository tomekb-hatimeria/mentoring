<?php

declare(strict_types=1);

namespace Mentoring\DisplayCustomer\Block;

use Magento\Customer\Model\Context as ModelContext;
use Magento\Customer\Model\Session;
use Magento\Customer\Model\SessionFactory;
use Magento\Framework\App\Http\Context as HttpContext;
use Magento\Framework\View\Element\Template;
use Magento\Framework\View\Element\Template\Context;

class DisplayProperty extends Template
{
    protected array $properties = [];
    public function __construct(
        protected HttpContext $httpContext,
        protected SessionFactory $customerSessionFactory,
        Context $context,
        array $data = []
    ) {
        $this->properties = $data['data']['properties'] ?? [];
        parent::__construct($context, $data);
    }

    public function getCustomerName(): string
    {
        if ($this->httpContext->getValue(ModelContext::CONTEXT_AUTH)) {
            /** @var Session */
            $customerSession = $this->customerSessionFactory->create();
            return $customerSession->getCustomer()->getName() ?: '';
        }

        return '';
    }

    public function getProperties(?string $propertyName = null)
    {
        if ($propertyName) {
            return $this->properties[$propertyName];
        }
        /** @var Session */
        $customerSession = $this->customerSessionFactory->create();
        $customer = $customerSession->getCustomer();
        foreach ($this->properties as $property) {
            yield $customer->getData($property);
        }
    }
}
