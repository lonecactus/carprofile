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
use Magento\Framework\App\ResponseInterface;
use Magento\Framework\Controller\ResultInterface;
use Magento\Framework\Controller\Result\Redirect;
use Magento\Framework\Controller\Result\RedirectFactory;
use Magento\Framework\Exception\AlreadyExistsException;
use Magento\Framework\Message\ManagerInterface;
use Razoyo\CarProfile\Helper\ConfigHelper;
use Razoyo\CarProfile\Model\Profile\Save as SaveProfile;

class Save implements HttpGetActionInterface
{

    /**
     * @var RequestInterface
     */
    protected RequestInterface $requestInterface;
    /**
     * @var RedirectFactory
     */
    protected RedirectFactory $redirectFactory;
    /**
     * @var SaveProfile
     */
    protected SaveProfile $saveProfile;
    /**
     * @var Session
     */
    protected Session $customerSession;
    /**
     * @var ManagerInterface
     */
    protected ManagerInterface $messageManager;
    /**
     * @var ConfigHelper
     */
    protected ConfigHelper $configHelper;

    /**
     * Constructor
     *
     * @param RequestInterface $requestInterface
     * @param RedirectFactory $redirectFactory
     * @param SaveProfile $saveProfile
     * @param Session $customerSession
     * @param ManagerInterface $messageManager
     * @param ConfigHelper $configHelper
     */
    public function __construct(
        RequestInterface $requestInterface,
        RedirectFactory  $redirectFactory,
        SaveProfile      $saveProfile,
        Session          $customerSession,
        ManagerInterface $messageManager,
        ConfigHelper     $configHelper
    ) {
        $this->requestInterface = $requestInterface;
        $this->redirectFactory = $redirectFactory;
        $this->saveProfile = $saveProfile;
        $this->customerSession = $customerSession;
        $this->messageManager = $messageManager;
        $this->configHelper = $configHelper;
    }

    /**
     * Save selected model to carprofile database
     *
     * @return ResultInterface|ResponseInterface|Redirect
     * @throws AlreadyExistsException
     */
    public function execute(): ResultInterface|ResponseInterface|Redirect
    {
        // disallow any direct route access and redirect to homepage if module config is disabled
        if (!$this->configHelper->isEnabled()) {
            $resultRedirect = $this->redirectFactory->create();
            $resultRedirect->setPath('cms/index/index');
            return $resultRedirect;
        }

        $selectedModelId = $this->requestInterface->getParam('selector_model');
        $customerId = (int) $this->customerSession->getCustomerId();
        $this->saveProfile->save($customerId, $selectedModelId);

        // remove Car List from session data; we're done with it now and it could be ginormous so let's get rid of it
        $this->customerSession->unsCarList();

        $resultRedirect = $this->redirectFactory->create();
        $resultRedirect->setPath('carprofile/profile/index');
        $this->messageManager->addSuccessMessage(__('Your car profile has been updated successfully'));
        return $resultRedirect;
    }
}
