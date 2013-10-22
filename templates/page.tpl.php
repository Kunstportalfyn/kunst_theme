<?php
/**
 * @file
 * Default theme implementation to display a single Drupal page.
 *
 * Available variables:
 *
 * General utility variables:
 * - $base_path: The base URL path of the Drupal installation. At the very
 *   least, this will always default to /.
 * - $directory: The directory the template is located in, e.g. modules/system
 *   or themes/garland.
 * - $is_front: TRUE if the current page is the front page.
 * - $logged_in: TRUE if the user is registered and signed in.
 * - $is_admin: TRUE if the user has permission to access administration pages.
 *
 * Site identity:
 * - $front_page: The URL of the front page. Use this instead of $base_path,
 *   when linking to the front page. This includes the language domain or
 *   prefix.
 * - $logo: The path to the logo image, as defined in theme configuration.
 * - $site_name: The name of the site, empty when display has been disabled
 *   in theme settings.
 * - $site_slogan: The slogan of the site, empty when display has been disabled
 *   in theme settings.
 *
 * Navigation:
 * - $main_menu (array): An array containing the Main menu links for the
 *   site, if they have been configured.
 * - $secondary_menu (array): An array containing the Secondary menu links for
 *   the site, if they have been configured.
 * - $breadcrumb: The breadcrumb trail for the current page.
 *
 * Page content (in order of occurrence in the default page.tpl.php):
 * - $title_prefix (array): An array containing additional output populated by
 *   modules, intended to be displayed in front of the main title tag that
 *   appears in the template.
 * - $title: The page title, for use in the actual HTML content.
 * - $title_suffix (array): An array containing additional output populated by
 *   modules, intended to be displayed after the main title tag that appears in
 *   the template.
 * - $messages: HTML for status and error messages. Should be displayed
 *   prominently.
 * - $tabs (array): Tabs linking to any sub-pages beneath the current page
 *   (e.g., the view and edit tabs when displaying a node).
 * - $action_links (array): Actions local to the page, such as 'Add menu' on the
 *   menu administration interface.
 * - $feed_icons: A string of all feed icons for the current page.
 * - $node: The node object, if there is an automatically-loaded node
 *   associated with the page, and the node ID is the second argument
 *   in the page's path (e.g. node/12345 and node/12345/revisions, but not
 *   comment/reply/12345).
 *
 * Regions:
 * - $page['help']: Dynamic help text, mostly for admin pages.
 * - $page['content']: The main content of the current page.
 * - $page['header']: Items for the header region.
 * - $page['footer']: Items for the footer region.
 *
 * @see template_preprocess()
 * @see template_preprocess_page()
 * @see template_process()
 */
?>
<div id="wrapper">
  <div id="shadow-wrapper">
    <header id="header" class="clearfix">
      <?php if (theme_get_setting('image_logo','kunst_theme')): ?>
        <?php if ($logo): ?>
        <div id="site-logo">
          <a href="<?php print $front_page; ?>" title="<?php print t('Home'); ?>">
            <img src="<?php print $logo; ?>" alt="<?php print t('Home'); ?>" />
          </a>
        <?php print render($page['header']); ?>
        </div>
        <?php endif; ?>
      <?php else: ?>
        <hgroup id="site-name-wrap">
          <h1 id="site-name">
            <a href="<?php print $front_page; ?>" title="<?php print t('Home'); ?>"><span><?php print $site_name; ?></span></a>
          </h1>
          <?php if ($site_slogan): ?><h2 id="site-slogan"><?php print $site_slogan; ?></h2><?php endif; ?>
        </hgroup>
      <?php endif; ?>
    </header>

    <div id="main" class="clearfix">
      <div id="primary">
        <section id="content" role="main">
          <?php print $messages; ?>
          <?php if ($page['content_top']): ?><div id="content_top"><?php print render($page['content_top']); ?></div><?php endif; ?>
          <?php if (theme_get_setting('breadcrumbs')): ?><?php if ($breadcrumb): ?><div id="breadcrumbs"><?php print $breadcrumb; ?></div><?php endif;?><?php endif; ?>
          <?php print render($title_prefix); ?>
          <?php if ($title): ?><h1 class="page-title"><?php print $title; ?></h1><?php endif; ?>
          <?php print render($title_suffix); ?>
          <?php if (!empty($tabs['#primary'])): ?><div class="tabs-wrapper clearfix"><?php print render($tabs); ?></div><?php endif; ?>
          <?php print render($page['help']); ?>
          <?php if ($action_links): ?><ul class="action-links"><?php print render($action_links); ?></ul><?php endif; ?>
          <?php print render($page['content']); ?>
        </section> <!-- /#main -->
      </div>
    </div>       
  </div>

  <?php if ($is_front): ?>
    <div id="shadow-bottom-front">
      <div id="footer-bottom-front">
        <div id="footer-area" class="clearfix">
          <?php if ($page['bottom_first'] || $page['bottom_second'] || $page['bottom_third']): ?>
            <div id="bottom-block-wrap" class="clearfix in<?php print (bool) $page['bottom_first'] + (bool) $page['bottom_second'] + (bool) $page['bottom_third']; ?>">
              <?php if ($page['bottom_first']): ?><div class="bottom-block">
              <?php print render($page['bottom_first']); ?>
                </div><?php endif; ?>
              <?php if ($page['bottom_second']): ?><div class="bottom-block">
              <?php print render($page['bottom_second']); ?>
                </div><?php endif; ?>
              <?php if ($page['bottom_third']): ?><div class="bottom-block">
              <?php print render($page['bottom_third']); ?>
                </div><?php endif; ?>
            </div>
          <?php endif; ?>
        </div>
      </div>
    </div>
  <?php endif; ?>

  <footer id="shadow-bottom">
    <div id="footer-bottom" class="clearfix">
      <div class="clearfix">
      <?php if ($page['footer_first'] || $page['footer_second'] || $page['footer_third']): ?>
        <div id="footer-block-wrap" class="clearfix in<?php print (bool) $page['footer_first'] + (bool) $page['footer_second'] + (bool) $page['footer_third']; ?>">
          <?php if($page['footer_first']): ?>
            <div class="footer-block"><?php print render($page['footer_first']); ?></div>
          <?php endif; ?>
          <?php if($page['footer_second']): ?>
            <div class="footer-block"><?php print render($page['footer_second']); ?></div>
          <?php endif; ?>
          <?php if($page['footer_third']): ?>
            <div class="footer-block"><?php print render($page['footer_third']); ?></div>
          <?php endif; ?>
          <?php if($page['footer_fourth']): ?>
            <div class="footer-block" ><?php print render($page['footer_fourth']); ?></div>
          <?php endif; ?>
        </div>
      <?php endif; ?>
      </div>
    </div>
  </footer>
  
  <div id="bottom" class="clearfix">
    <?php if (theme_get_setting('socialicon_display', 'kunst_theme')): ?>
    <?php 
    $twitter_url = check_plain(theme_get_setting('twitter_url', 'kunst_theme')); 
    $facebook_url = check_plain(theme_get_setting('facebook_url', 'kunst_theme')); 
    ?>
    <div class="social-profile">
      <ul>
        <?php if ($facebook_url): ?>
        <li><a target="_blank" title="<?php print $site_name; ?> in Facebook" href="<?php print $facebook_url; ?>"><i class="icon-facebook-sign" ></i></a></li>
        <?php endif; ?>
        <?php if ($twitter_url): ?>
        <li><a target="_blank" title="<?php print $site_name; ?> in Twitter" href="<?php print $twitter_url; ?>"><i class="icon-twitter-sign" > </i></a></li>
        <?php endif; ?>
        <li><a target="_blank" title="<?php print $site_name; ?> in RSS" href="<?php print $front_page; ?>rss.xml"> <i class="icon-rss-sign" > </i></a></li>
      </ul>
    </div>
    <?php endif; ?>
    <div class="credit">Kunstportal Fyn er et samarbejdsprojekt mellem de fynske folkebiblioteker støttet af Kulturregion Fyn · Om Kunstportalfyn.dk · Kontakt os</div>
  </div>
</div>
