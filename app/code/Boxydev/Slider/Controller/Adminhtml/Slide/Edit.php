<?php

/*
 * This file is part of the magento.com package.
 *
 * (c) Matthieu Mota <matthieu@boxydev.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Boxydev\Slider\Controller\Adminhtml\Slide;

use Boxydev\Slider\Model\ResourceModel\Slide as ResourceSlide;
use Boxydev\Slider\Model\Slide;
use Boxydev\Slider\Model\SlideFactory;
use Magento\Backend\App\Action;
use Magento\Backend\Model\View\Result\Page;
use Magento\Catalog\Model\ImageUploader;
use Magento\Framework\Controller\ResultFactory;

class Edit extends Action
{
    /**
     * @var SlideFactory
     */
    private $slideFactory;

    /**
     * @var ResourceSlide
     */
    private $resourceSlide;

    /**
     * @var ImageUploader
     */
    private $imageUploader;

    public function __construct(
        Action\Context $context,
        SlideFactory $slideFactory,
        ResourceSlide $resourceSlide,
        ImageUploader $imageUploader
    ) {
        parent::__construct($context);
        $this->slideFactory = $slideFactory;
        $this->resourceSlide = $resourceSlide;
        $this->imageUploader = $imageUploader;
    }

    protected function _isAllowed()
    {
        return $this->_authorization->isAllowed('Boxydev_Slider::slide_save');
    }

    public function execute()
    {
        /** @var Page $result */
        $result = $this->resultFactory->create(ResultFactory::TYPE_PAGE);
        $result->setActiveMenu('Boxydev_Slider::head');

        $slideData = $this->getRequest()->getPostValue();

        if ($slideData) {
            /** @var Slide $slide */
            $slide = $this->slideFactory->create();

            if ($id = $this->getRequest()->getParam('id')) {
                $this->resourceSlide->load($slide, $id);
            }

            $slide->addData([
                'name' => $slideData['name'],
                'image' => $slideData['image'][0]['name'] ?? null
            ]);

            $this->resourceSlide->save($slide);

            if ($slide->getData('image')) {
                $this->imageUploader->moveFileFromTmp($slide->getData('image'));
            }

            $this->messageManager->addSuccessMessage(__('Success'));

            return $this->resultRedirectFactory->create()->setPath('*/*/');
        }

        return $result;
    }
}
