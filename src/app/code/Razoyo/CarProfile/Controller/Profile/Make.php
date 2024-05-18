<?php
/**
 * @author    Razoyo <razoyo@razoyo.com>
 * @copyright Copyright 2024 © Razoyo. All Rights Reserved.
 */

declare(strict_types=1);

namespace Razoyo\CarProfile\Controller\Profile;

use Magento\Customer\Model\Session;
use Magento\Framework\App\Action\HttpGetActionInterface;
use Magento\Framework\App\RequestInterface;
use Magento\Framework\Controller\Result\Json;
use Magento\Framework\Controller\Result\JsonFactory;
use Magento\Framework\Controller\Result\Redirect;
use Magento\Framework\Controller\Result\RedirectFactory;
use Razoyo\CarProfile\Helper\ConfigHelper;
use Razoyo\CarProfile\Model\Profile\DropdownParser;

class Make implements HttpGetActionInterface
{
    /**
     * @var JsonFactory
     */
    protected JsonFactory $resultJsonFactory;
    /**
     * @var Session
     */
    protected Session $customerSession;
    /**
     * @var RedirectFactory
     */
    protected RedirectFactory $redirectFactory;
    /**
     * @var ConfigHelper
     */
    protected ConfigHelper $configHelper;
    /**
     * @var DropdownParser
     */
    protected DropdownParser $dropdownParser;
    /**
     * @var RequestInterface
     */
    protected RequestInterface $requestInterface;

    /**
     * @param JsonFactory $resultJsonFactory
     * @param Session $customerSession
     * @param ConfigHelper $configHelper
     * @param RedirectFactory $redirectFactory
     * @param DropdownParser $dropdownParser
     * @param RequestInterface $requestInterface
     */
    public function __construct(
        JsonFactory      $resultJsonFactory,
        Session          $customerSession,
        ConfigHelper     $configHelper,
        RedirectFactory  $redirectFactory,
        DropdownParser   $dropdownParser,
        RequestInterface $requestInterface
    ) {
        $this->resultJsonFactory = $resultJsonFactory;
        $this->customerSession = $customerSession;
        $this->redirectFactory = $redirectFactory;
        $this->configHelper = $configHelper;
        $this->dropdownParser = $dropdownParser;
        $this->requestInterface = $requestInterface;
    }

    /**
     * Return a list of vehicle makes that are available for the year the user selected
     *
     * @return Json|Redirect
     */
    public function execute(): Json|Redirect
    {
        // disallow any direct route access and redirect to homepage if module config is disabled
        if (!$this->configHelper->isEnabled()) {
            $resultRedirect = $this->redirectFactory->create();
            $resultRedirect->setPath('cms/index/index');
            return $resultRedirect;
        }

        $result = $this->resultJsonFactory->create();

        $html = '<option selected="selected" value="">'.__('Select Make').'</option>';

        $carList = $this->customerSession->getCarList();
        $selectedYear = $this->requestInterface->getParam('year');

        $filteredMakes = $this->dropdownParser->parseMakes($selectedYear, $carList);

        foreach ($filteredMakes as $make) {
            $html .= '<option value="'.$make.'">'.$make.'</option>';
        }

        return $result->setData(['success' => true, 'value' => $html]);
    }
}
