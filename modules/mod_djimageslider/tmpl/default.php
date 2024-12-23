<?php
/**
 * @version $Id$
 * @package DJ-ImageSlider
 * @subpackage DJ-ImageSlider Component
 * @copyright Copyright (C) 2017 DJ-Extensions.com, All rights reserved.
 * @license http://www.gnu.org/licenses GNU/GPL
 * @author url: http://dj-extensions.com
 * @author email contact@dj-extensions.com
 * @developer Szymon Woronowski - szymon.woronowski@design-joomla.eu
 *
 *
 * DJ-ImageSlider is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * DJ-ImageSlider is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with DJ-ImageSlider. If not, see <http://www.gnu.org/licenses/>.
 *
 */

// no direct access
defined('_JEXEC') or die ('Restricted access'); 

use Joomla\CMS\Factory;
use Joomla\CMS\Language\Text;

$wcag = $params->get('wcag', 1) ? ' tabindex="0"' : '';

// Customization parameters
$title_color = $params->get('title_color');
$desc_color = $params->get('desc_color');
$readmore_color = $params->get('readmore_color');
$desc_bg = $params->get('desc_bg');

$title_font = $params->get('title_font', '');
$desc_font = $params->get('desc_font', '');
$readmore_font = $params->get('readmore_font', '');


$title_style = (($title_color) ? 'color:' . $title_color . ';' : '') . (($title_font != '') ? 'font-family:\'' . $title_font . '\';' : '');
$desc_style = (($desc_color) ? 'color:' . $desc_color . ';' : '') . (($desc_font != '') ? 'font-family:\'' . $desc_font . '\';' : '');
$readmore_style = (($readmore_color) ? 'color:' . $readmore_color . ';' : '') . (($readmore_font != '') ? 'font-family:\'' . $readmore_font . '\';' : '');

$border_radius = $params->get('border_radius', '0px 0px 0px 0px;');

if($params->get('include_gf')) {
    $document = Factory::getDocument();
    $document->addStyleSheet('//fonts.googleapis.com/css?family=' . modDJImageSliderHelper::getGoogleFontSlug(array($title_font, $desc_font, $readmore_font)));
}

?>


<div style="border: 0px !important;">
    <div id="djslider-loader<?php echo $mid; ?>" class="djslider-loader djslider-loader-<?php echo $theme ?>" data-animation='<?php echo $animationOptions ?>' data-djslider='<?php echo $moduleSettings ?>'<?php echo $wcag; ?>>
        <div id="djslider<?php echo $mid; ?>" class="djslider djslider-<?php echo $theme; echo $params->get('image_centering', 0) ? ' img-vcenter':'' ?>" style="<?php echo $style['slider'] ?>">
            <div id="slider-container<?php echo $mid; ?>" class="slider-container" <?php echo (($border_radius != '0px 0px 0px 0px;') ? 'style="border-radius:' . $border_radius . ';"' : '')?>>
                <ul id="slider<?php echo $mid; ?>" class="djslider-in">
                    <?php foreach ($slides as $slide) {

                        if(isset($slide->params)) {
                            $link_element = $slide->params->get('link_element', '');
                        } else {
                            $link_element = '';
                        }


                        $rel = (!empty($slide->rel) ? 'rel="'.$slide->rel.'"':''); ?>
                        <li style="<?php echo $style['slide'] ?>">
                            <?php if($slide->image) {
                                $action = $params->get('link_image',1);
                                if($action > 1) {
                                    $desc = $params->get('show_desc') ? 'title="'.(!empty($slide->title) ? htmlspecialchars($slide->title.' ') : '').(!empty($slide->description) ? htmlspecialchars('<small>'.strip_tags($slide->description,"<p><a><b><strong><em><i><u>").'</small>') : '').'"':'';
                                    if($jquery) {
                                        $attr = 'class="image-link" data-'.$desc;

                                    } else {
                                        $attr = 'rel="lightbox-slider'.$mid.'" '.$desc;
                                    }
                                } else {
                                    $attr = $rel;
                                }
                                ?>
                                <?php if ((($slide->link && $action==1) || $action>1) && ($link_element == 'img' || $link_element == '')) { ?>
                                    <a <?php echo $attr; ?> href="<?php echo ($action>1 ? $slide->image : $slide->link); ?>" target="<?php echo $slide->target; ?>">
                                <?php } ?>
                                <img class="dj-image" src="<?php echo $slide->image; ?>" <?php echo (($slide->alt) ? 'alt="' . $slide->alt . '"' : '') ?> <?php echo (!empty($slide->img_title) ? ' title="'.$slide->img_title.'"':''); ?> style="<?php echo $style['image'] ?>"/>
                                <?php if ((($slide->link && $action==1) || $action>1) && ($link_element == 'img' || $link_element == '')) { ?>
                                    </a>
                                <?php } ?>
                            <?php } ?>
                            <?php if($params->get('slider_source') && ($params->get('show_title') || ($params->get('show_desc') && !empty($slide->description) || ($params->get('show_readmore') && $slide->link)))) { ?>
                                <!-- Slide description area: START -->
                                <div class="slide-desc" style="<?php echo $style['desc'] ?>">
                                    <div class="slide-desc-in">
                                        <div class="slide-desc-bg slide-desc-bg-<?php echo $theme ?>" style="background: <?php echo $desc_bg; ?>"></div>
                                        <div class="slide-desc-text slide-desc-text-<?php echo $theme ?>">
                                            <?php if($params->get('show_title')) { ?>
                                                <div class="slide-title" <?php echo (!($params->get('link_title') && $slide->link) ? 'style="' . $title_style . '"' : '');?>>
                                                    <?php if($params->get('link_title') && $slide->link) { ?><a style="<?php echo $title_style; ?>" href="<?php echo $slide->link; ?>" target="<?php echo $slide->target; ?>" <?php echo $rel; ?>><?php } ?>
                                                        <?php echo $slide->title; ?>
                                                        <?php if($params->get('link_title') && $slide->link) { ?></a><?php } ?>
                                                </div>
                                            <?php } ?>

                                            <?php if($params->get('show_desc')) { ?>
                                                <div class="slide-text" <?php echo (!($params->get('link_desc') && $slide->link) ? 'style="' . $desc_style . '"' : ''); ?>>
                                                    <?php if($params->get('link_desc') && $slide->link) { ?>
                                                        <a href="<?php echo $slide->link; ?>" style="<?php echo $desc_style ?>" target="<?php echo $slide->target; ?>" <?php echo $rel; ?>>
                                                            <?php echo strip_tags($slide->description,"<br><span><em><i><b><strong><small><big>"); ?>
                                                        </a>
                                                    <?php } else { ?>
                                                        <?php echo $slide->description; ?>
                                                    <?php } ?>
                                                </div>
                                            <?php } ?>

                                            <?php if($params->get('show_readmore') && $slide->link && ($link_element == 'read_more' || $link_element == '')) { ?>
                                                <a href="<?php echo $slide->link; ?>" style="<?php echo $readmore_style; ?>" target="<?php echo $slide->target; ?>" <?php echo $rel; ?> class="readmore"><?php echo ($params->get('readmore_text',0) ? $params->get('readmore_text') : JText::_('MOD_DJIMAGESLIDER_READMORE')); ?></a>
                                            <?php } ?>
                                            <div style="clear: both"></div>
                                        </div>
                                    </div>
                                </div>
                                <!-- Slide description area: END -->
                            <?php } ?>

                        </li>
                    <?php } ?>
                </ul>
            </div>
            <?php if($show->arr || $show->btn) { ?>
                <div id="navigation<?php echo $mid; ?>" class="navigation-container" style="<?php echo $style['navi'] ?>">
                    <?php if($show->arr) { ?>
                        <img id="prev<?php echo $mid; ?>" class="prev-button <?php echo $show->arr==1 ? 'showOnHover':'' ?>" src="<?php echo $navigation->prev; ?>" alt="<?php echo $direction == 'rtl' ? Text::_('MOD_DJIMAGESLIDER_NEXT') : Text::_('MOD_DJIMAGESLIDER_PREVIOUS'); ?>"<?php echo $wcag; ?> />
                        <img id="next<?php echo $mid; ?>" class="next-button <?php echo $show->arr==1 ? 'showOnHover':'' ?>" src="<?php echo $navigation->next; ?>" alt="<?php echo $direction == 'rtl' ? Text::_('MOD_DJIMAGESLIDER_PREVIOUS') : Text::_('MOD_DJIMAGESLIDER_NEXT'); ?>"<?php echo $wcag; ?> />
                    <?php } ?>
                    <?php if($show->btn) { ?>
                        <img id="play<?php echo $mid; ?>" class="play-button <?php echo $show->btn==1 ? 'showOnHover':'' ?>" src="<?php echo $navigation->play; ?>" alt="<?php echo Text::_('MOD_DJIMAGESLIDER_PLAY'); ?>"<?php echo $wcag; ?> />
                        <img id="pause<?php echo $mid; ?>" class="pause-button <?php echo $show->btn==1 ? 'showOnHover':'' ?>" src="<?php echo $navigation->pause; ?>" alt="<?php echo Text::_('MOD_DJIMAGESLIDER_PAUSE'); ?>"<?php echo $wcag; ?> />
                    <?php } ?>
                </div>
            <?php } ?>
            <?php if($show->idx) { ?>
                <div id="cust-navigation<?php echo $mid; ?>" class="<?php echo $params->get('idx_style', 0) ? 'navigation-numbers' : 'navigation-container-custom' ?> <?php echo $show->idx==2 ? 'showOnHover':'' ?>">
                    <?php $i = 0; foreach ($slides as $slide) {
                        ?><span class="load-button<?php if ($i == 0) echo ' load-button-active'; ?>"<?php echo $wcag; ?>><?php if($params->get('idx_style')) echo ($i+1) ?></span><?php
                        $i++; } ?>
                </div>
            <?php } ?>
        </div>
    </div>
</div>
<div class="djslider-end" style="clear: both"<?php echo $wcag; ?>></div>