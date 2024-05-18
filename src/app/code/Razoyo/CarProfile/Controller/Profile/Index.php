<?php
/**
 * @author    Razoyo <razoyo@razoyo.com>
 * @copyright Copyright 2024 © Razoyo. All Rights Reserved.
 */

declare(strict_types=1);

namespace Razoyo\CarProfile\Controller\Profile;

use Magento\Customer\Model\Session;
use Magento\Framework\App\Action\HttpGetActionInterface;
use Magento\Framework\App\ResponseInterface;
use Magento\Framework\Controller\Result\Redirect;
use Magento\Framework\Controller\Result\RedirectFactory;
use Magento\Framework\Controller\ResultInterface;
use Magento\Framework\Exception\SessionException;
use Magento\Framework\View\Result\Page;
use Magento\Framework\View\Result\PageFactory;
use Razoyo\CarProfile\Helper\ConfigHelper;

class Index implements HttpGetActionInterface
{
    /**
     * @var PageFactory
     */
    protected PageFactory $resultPageFactory;
    /**
     * @var Session
     */
    protected Session $customerSession;
    /**
     * @var ConfigHelper
     */
    protected ConfigHelper $configHelper;
    /**
     * @var RedirectFactory
     */
    protected RedirectFactory $redirectFactory;

    /**
     * @param PageFactory $resultPageFactory
     * @param Session $customerSession
     * @param ConfigHelper $configHelper
     * @param RedirectFactory $redirectFactory
     */
    public function __construct(
        PageFactory     $resultPageFactory,
        Session         $customerSession,
        ConfigHelper    $configHelper,
        RedirectFactory $redirectFactory
    ) {
        $this->resultPageFactory = $resultPageFactory;
        $this->customerSession = $customerSession;
        $this->configHelper = $configHelper;
        $this->redirectFactory = $redirectFactory;
    }

    /**
     * @return ResponseInterface|Redirect|ResultInterface|Page
     * @throws SessionException
     */
    public function execute(): Page|ResultInterface|ResponseInterface|Redirect
    {
        // disallow any direct route access and redirect to homepage if module config is disabled
        if (!$this->configHelper->isEnabled()) {
            $resultRedirect = $this->redirectFactory->create();
            $resultRedirect->setPath('cms/index/index');
            return $resultRedirect;
        }

        // require user to log in before viewing this page
        if (!$this->customerSession->isLoggedIn()) {
            $this->customerSession->authenticate();
        }

        return $this->resultPageFactory->create();
    }
}
