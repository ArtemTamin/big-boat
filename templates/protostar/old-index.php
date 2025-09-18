<?php
/**
 * @package     Joomla.Site
 * @subpackage  Templates.protostar
 *
 * @copyright   Copyright (C) 2005 - 2016 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

$app             = JFactory::getApplication();
$doc             = JFactory::getDocument();
$user            = JFactory::getUser();
$this->language  = $doc->language;
$this->direction = $doc->direction;

// Output as HTML5
$doc->setHtml5(true);

// Getting params from template
$params = $app->getTemplate(true)->params;

// Detecting Active Variables
$option   = $app->input->getCmd('option', '');
$view     = $app->input->getCmd('view', '');
$layout   = $app->input->getCmd('layout', '');
$task     = $app->input->getCmd('task', '');
$itemid   = $app->input->getCmd('Itemid', '');
$sitename = $app->get('sitename');

if($task == "edit" || $layout == "form" )
{
	$fullWidth = 1;
}
else
{
	$fullWidth = 0;
}

// Add JavaScript Frameworks
JHtml::_('bootstrap.framework');

$is_gpsi = 0;
if(strpos($_SERVER['HTTP_USER_AGENT'], 'Lighthouse')!='' || strpos($_SERVER['HTTP_USER_AGENT'], 'Insights')!=''){
	$is_gpsi = 1;
}

$doc->addScriptVersion($this->baseurl . '/templates/' . $this->template . '/js/template.js');

// Add Stylesheets
$doc->addStyleSheetVersion($this->baseurl . '/templates/' . $this->template . '/css/template.css?07122020');

// Use of Google Font
if ($this->params->get('googleFont'))
{
	$doc->addStyleSheet('//fonts.googleapis.com/css?family=' . $this->params->get('googleFontName'));
	$doc->addStyleDeclaration("
	h1, h2, h3, h4, h5, h6, .site-title {
		font-family: '" . str_replace('+', ' ', $this->params->get('googleFontName')) . "', sans-serif;
	}");
}

// Template color
if ($this->params->get('templateColor'))
{
	$doc->addStyleDeclaration("
	body.site {
		border-top: 3px solid " . $this->params->get('templateColor') . ";
		background-color: " . $this->params->get('templateBackgroundColor') . ";
	}
	a {
		color: " . $this->params->get('templateColor') . ";
	}
	.nav-list > .active > a,
	.nav-list > .active > a:hover,
	.dropdown-menu li > a:hover,
	.dropdown-menu .active > a,
	.dropdown-menu .active > a:hover,
	.nav-pills > .active > a,
	.nav-pills > .active > a:hover,
	.btn-primary {
		background: " . $this->params->get('templateColor') . ";
	}");
}

// Check for a custom CSS file
$userCss = JPATH_SITE . '/templates/' . $this->template . '/css/user.css';

if (file_exists($userCss) && filesize($userCss) > 0)
{
	$this->addStyleSheetVersion($this->baseurl . '/templates/' . $this->template . '/css/user.css');
}

// Load optional RTL Bootstrap CSS
JHtml::_('bootstrap.loadCss', false, $this->direction);

// Adjusting content width
if ($this->countModules('position-7') && $this->countModules('position-8'))
{
	$span = "span6";
}
elseif ($this->countModules('position-7') && !$this->countModules('position-8'))
{
	$span = "span9";
}
elseif (!$this->countModules('position-7') && $this->countModules('position-8'))
{
	$span = "span9";
}
else
{
	$span = "span12";
}

// Logo file or site title param
/*if ($this->params->get('logoFile'))
{
	$logo = '<img src="' . JUri::root() . $this->params->get('logoFile') . '" alt="' . $sitename . '" />';
}
elseif ($this->params->get('sitetitle'))
{
	$logo = '<span class="site-title" title="' . $sitename . '">' . htmlspecialchars($this->params->get('sitetitle'), ENT_COMPAT, 'UTF-8') . '</span>';
}
else
{
	$logo = '<span class="site-title" title="' . $sitename . '">' . $sitename . '</span>';
}*/
?>

<!DOCTYPE html>
<html lang="<?php echo $this->language; ?>" dir="<?php echo $this->direction; ?>">
<head>
	<meta name="viewport" content="width=device-width, initial-scale=1.0" />
	<meta name="cmsmagazine" content="8b36d65ed1338137afa3f37f0cc274d3" />
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, minimum-scale=1, user-scalable=no">
	<jdoc:include type="head" />
<? if($is_gpsi==0){?>
	<!--[if lt IE 9]><script src="<?php echo JUri::root(true); ?>/media/jui/js/html5.js"></script><![endif]-->
	<script src='/js/sipuni-calltracking.js'></script>
	<script src="https://cdn.jsdelivr.net/npm/jquery@3.2.1/dist/jquery.min.js" type="text/javascript"></script>
<script src="https://cdn.jsdelivr.net/npm/jquery.maskedinput@1.4.1/src/jquery.maskedinput.min.js" type="text/javascript"></script>
<?}?>
</head>
<body class="site <?php echo $option
	. ' view-' . $view
	. ($layout ? ' layout-' . $layout : ' no-layout')
	. ($task ? ' task-' . $task : ' no-task')
	. ($itemid ? ' itemid-' . $itemid : '')
	. ($params->get('fluidContainer') ? ' fluid' : '');
	echo ($this->direction == 'rtl' ? ' rtl' : '');
?>">
	<!-- Body -->
	<div class="body">
		<div class="container<?php echo ($params->get('fluidContainer') ? '-fluid' : ''); ?>">
			<!-- Header -->
			<header class="header" >
				<? if($is_gpsi==0){?><jdoc:include type="modules" name="dopTopMenu" style="none" /><?}?>
				<div class="header-inner">

      <!--Позиция top -->
	        <div class="header-item">
            <div class="top">
            <? if($is_gpsi==0){?><jdoc:include type="modules" name="top" style="none" /><?}?>
            </div>
			
            </div>

      <!--Позиция phoneNumber -->
            <div class="header-item" >
            
            <div class="phoneNumber" >
					<? if($is_gpsi==0){?><jdoc:include type="modules" name="TopphoneNumber" style="none" /><?}?>
                   	<!-- <div class="ct_phone" style="font-size:xx-large; margin-top: 0px;"><a href="tel:88002508076">8-800-250-80-76</a></div>
    				<div style="font-size:medium;padding-top: 0px;margin-top: 5px">Бесплатные звонки по России</div> -->
            </div>
            </div>

       <!--Позиция vhod -->
            <div class="header-item">
			<div class="social-block"><jdoc:include type="modules" name="socialblock" style="none" /></div>
            <div class="vhod">
            <jdoc:include type="modules" name="vhod" style="none" />
			</div>
            </div>

				</div>
			</header>
			<?php if ($this->countModules('position-1')) : ?>
				<nav class="navigation" role="navigation">
					<div class="navbar pull-left">
						<div class="vhod">
							<jdoc:include type="modules" name="vhod" style="none" />
						</div>
						<a class="btn btn-navbar collapsed" data-toggle="collapse" data-target=".nav-collapse">
						<span class="slicknav_menutxt">Меню</span>
							<span class="icon-bar"></span>
							<span class="icon-bar"></span>
							<span class="icon-bar"></span>
						</a>
					</div>
					<div class="nav-collapse">
						<? if($is_gpsi==0){?><jdoc:include type="modules" name="position-1" style="none" /><?}?>
						<div class="vhod">
							<jdoc:include type="modules" name="vhod" style="none" />
						</div>
					</div>
				</nav>
			<?php endif; ?>
			<jdoc:include type="modules" name="banner" style="xhtml" />
			<div class="row-fluid">
				<?php if ($this->countModules('position-8')) : ?>
					<!-- Begin Sidebar -->
					<div id="sidebar" class="span3">
						<div class="sidebar-nav">
							<? if($is_gpsi==0){?><jdoc:include type="modules" name="position-8" style="xhtml" /><?}?>
						</div>
					</div>
					<!-- End Sidebar -->
				<?php endif; ?>
				<main id="content" role="main" class="<?php echo $span; ?>">
					<!-- Begin Content -->
                    
                <!--<div id="totalusage">
                       <div class="mymenu">
                            <jdoc:include type="modules" name="position-3" style="xhtml" />
                        </div>

                        <div class="myslider" id="qweqwe">
                            <jdoc:include type="modules" name="position-14" style="none" />
                        </div>

                     </div>
 -->
                
                  
                   
 					<? if($is_gpsi==0){?><jdoc:include type="message" /><?}?>
					<jdoc:include type="component" />
					<?/* if($is_gpsi==0){?><jdoc:include type="modules" name="position-2" style="none" /><?}*/?>
					<!-- End Content -->

				</main>
				<?php if ($this->countModules('position-7')) : ?>
					<div id="aside" class="span3">
						<!-- Begin Right Sidebar -->
						<? if($is_gpsi==0){?><jdoc:include type="modules" name="position-7" style="well" /><?}?>
						<!-- End Right Sidebar -->
					</div>
				<?php endif; ?>
			</div>
		</div>
	</div>
	<!-- Footer -->
	<footer class="footer" role="contentinfo">
		<div class="container<?php echo ($params->get('fluidContainer') ? '-fluid' : ''); ?>">
			<hr />
			<? if($is_gpsi==0){?><jdoc:include type="modules" name="footer" style="none" /><?}?>
		</div>
	</footer>
	<? if($is_gpsi==0){?>
		<jdoc:include type="modules" name="debug" style="none" />
		<!-- uSocial -->
		<!--<script async src="https://usocial.pro/usocial/usocial.js?v=6.1.4" data-script="usocial" charset="utf-8"></script>
		<div class="uSocial-Share" data-pid="8d78b5ac0f586e95887665cff6690194" data-type="share" data-options="round-rect,style1,default,right,slide-down,size32,eachCounter1,eachCounter-bottom,counter0" data-social="vk,fb,ok,twi" data-mobile="vi,wa,sms"></div>-->
		<!-- /uSocial -->
		  <!-- Yandex.Metrika counter --> <script type="text/javascript" > (function(m,e,t,r,i,k,a){m[i]=m[i]||function(){(m[i].a=m[i].a||[]).push(arguments)}; m[i].l=1*new Date();k=e.createElement(t),a=e.getElementsByTagName(t)[0],k.async=1,k.src=r,a.parentNode.insertBefore(k,a)}) (window, document, "script", "https://mc.yandex.ru/metrika/tag.js", "ym"); ym(36842045, "init", { clickmap:true, trackLinks:true, accurateTrackBounce:true, webvisor:true }); </script> <noscript><div><img src="https://mc.yandex.ru/watch/36842045" style="position:absolute; left:-9999px;" alt="" /></div></noscript> <!-- /Yandex.Metrika counter -->
		  <script>
		  sipuniCalltracking({
			sources: {
			   'vkontakte':{'utm_source': 'vk'},
			   'vkontakte_mobile':{'utm_source': /vk_mobile/ig}
			},
			phones: [
			   {'src':'vkontakte', 'phone':['+79850058045']},
			   {'src':'vkontakte_mobile', 'phone':['+79850058045']}
			],
			pattern:'+# (###) ###-##-##'
		  }, window);
		</script>
	<?}?>
</body>
</html>