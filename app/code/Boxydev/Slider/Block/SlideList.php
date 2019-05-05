<?php

/*
 * This file is part of the magento.com package.
 *
 * (c) Matthieu Mota <matthieu@boxydev.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Boxydev\Slider\Block;

use Boxydev\Slider\Model\ResourceModel\Slide\Collection;
use Magento\Framework\View\Element\Template;
use Magento\Theme\Block\Html\Breadcrumbs;

class SlideList extends Template
{
    /**
     * @var Collection
     */
    private $collection;

    public function __construct(
        Template\Context $context,
        Collection $collection,
        array $data = []
    ) {
        parent::__construct($context, $data);
        $this->collection = $collection;
    }

    protected function _prepareLayout()
    {
        parent::_prepareLayout();

        $this->getLayout()->createBlock(\Magento\Catalog\Block\Breadcrumbs::class);
        /** @var Breadcrumbs $breadcrumbs */
        $breadcrumbs = $this->getLayout()->getBlock('breadcrumbs');
        $breadcrumbs->addCrumb('slide', [
            'label' => 'Slide',
            'title' => 'Slide',
            'link' => false
        ]);

        $this->pageConfig->getTitle()->set('Slides de Boxydev');
        $this->pageConfig->setDescription('Meta desc');
        $this->pageConfig->setKeywords('a, b, c');
    }

    public function getSlides()
    {
        $collection = $this->collection->addFieldToFilter('image', ['notnull' => '']);
        echo $collection->getSelect();

        return $collection;
    }
}
