<?php

declare(strict_types=1);

namespace Lwc\CmsBundle\Menu;

use Sylius\Bundle\UiBundle\Menu\Event\MenuBuilderEvent;

final class ContentManagementMenuBuilder
{
    public function buildMenu(MenuBuilderEvent $menuBuilderEvent): void
    {
        $menu = $menuBuilderEvent->getMenu();

        $cmsRootMenuItem = $menu
            ->addChild('lwc_cms')
            ->setLabel('lwc_cms.ui.cms')
        ;

        $cmsRootMenuItem
            ->addChild('blocks', [
                'route' => 'lwc_cms_admin_block_index',
            ])
            ->setLabel('lwc_cms.ui.blocks')
            ->setLabelAttribute('icon', 'block layout')
        ;

        $cmsRootMenuItem
            ->addChild('media', [
                'route' => 'lwc_cms_admin_media_index',
            ])
            ->setLabel('lwc_cms.ui.media')
            ->setLabelAttribute('icon', 'file')
        ;

        $cmsRootMenuItem
            ->addChild('pages', [
                'route' => 'lwc_cms_admin_page_index',
            ])
            ->setLabel('lwc_cms.ui.pages')
            ->setLabelAttribute('icon', 'sticky note')
        ;

        $cmsRootMenuItem
            ->addChild('faq', [
                'route' => 'lwc_cms_admin_frequently_asked_question_index',
            ])
            ->setLabel('lwc_cms.ui.faq')
            ->setLabelAttribute('icon', 'help')
        ;

        $cmsRootMenuItem
            ->addChild('sections', [
                'route' => 'lwc_cms_admin_section_index',
            ])
            ->setLabel('lwc_cms.ui.sections')
            ->setLabelAttribute('icon', 'grid layout')
        ;
    }
}
