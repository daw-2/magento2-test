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

use Magento\Backend\App\Action;
use Magento\Backend\Model\View\Result\Forward;
use Magento\Framework\Controller\ResultFactory;

class Create extends Action
{
    /**
     * On vérifie les ACLs.
     *
     * @return bool
     */
    protected function _isAllowed()
    {
        return $this->_authorization->isAllowed('Boxydev_Slider::slide_save');
    }

    public function execute()
    {
        /** @var Forward $resultPage */
        $resultPage = $this->resultFactory->create(ResultFactory::TYPE_FORWARD);

        return $resultPage->forward('edit');
    }
}
