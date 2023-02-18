<?php
include_once('Db.php');
include_once('Utils.php');
include_once('credentials.php');

function loadConfig() {
if(file_exists('config.ini'))
    {
      $config = parse_ini_file("config.ini");
      return array("orderID" => $config["orderID"]);
    } else
    return array();
}

$configData = loadConfig();

$content = Db::queryOne('SELECT aboutus.*, contacts.*, metatags.*, domains.*, cta.*, headlines.*, opening_time.* FROM aboutus 
          LEFT JOIN contacts ON aboutus.order_id = contacts.order_id
          LEFT JOIN metatags ON aboutus.order_id = metatags.order_id
          LEFT JOIN domains ON aboutus.order_id = domains.order_id
          LEFT JOIN cta ON aboutus.order_id = cta.order_id
          LEFT JOIN headlines ON aboutus.order_id = headlines.order_id
          LEFT JOIN opening_time ON aboutus.order_id = opening_time.order_id
          WHERE aboutus.order_id = ?', array($configData['orderID']));

$features = Db::queryAll('SELECT * FROM `features` WHERE `order_id` = ?', array($configData['orderID']));
$faqs = Db::queryAll('SELECT * FROM `faq` WHERE `order_id` = ?', array($configData['orderID']));
$services = Db::queryAll('SELECT * FROM `services` WHERE `order_id` = ?', array($configData['orderID']));
?>
<!DOCTYPE html>
<html lang="cs">
    <head>
        <!-- Meta Tags -->
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">		
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=0">
		<meta name="description" content="<?= $content['meta_description']?>">
		<meta name="keywords" content="nouzové otevírání dveří, oprava autoklíčů, servis autoklíčů, zamykací systémy, cylindrické vložky, výroba klíčů, Bohumín, zámečnictví, zámečník">
        <meta name="author" content="Stanislav Drako">
		<meta property="og:type" content="website" /> 
		<meta property="og:title" content="<?= $content['og_title']?>" />
		<meta property="og:image" content="assets/images/facebook_og.jpg">
		<meta property="og:url" content="https://<?= $content['domain']?>" />
		<meta property="og:description" content="<?= $content['og_description']?>" /> <!-- around 200 characters-->
		<meta property="og:locale" content="cs_CZ" />
		<link rel=”canonical” href="https://<?= $content['domain']?>" />

        <!-- Page Title -->
        <title><?= $content['meta_title'] ?></title>

        <!-- Favicon and touch Icons -->
        <link href="assets/images/favicon.png" rel="shortcut icon" type="image/png">
        <link href="assets/images/apple-touch-icon.png" rel="apple-touch-icon">
        <link href="assets/images/apple-touch-icon-72x72.png" rel="apple-touch-icon" sizes="72x72">
        <link href="assets/images/apple-touch-icon-114x114.png" rel="apple-touch-icon" sizes="114x114">
        <link href="assets/images/apple-touch-icon-144x144.png" rel="apple-touch-icon" sizes="144x144">

        <!-- Lead Style -->
        <link href="assets/css/style.css" rel="stylesheet" type="text/css">
    </head>

    <body>
		<!--PreLoader-->
		<div class="preloader">
			<div class="preloader-inner">
				<div class="siteloading-preloader"></div>
			</div>
		</div>
		<!--PreLoader Ends-->

		<!-- Header 1 -->
		<header class="header">
			<div class="top_bar">
				<div class="container">
					<div class="top_bar_inner">
						<div class="header_social">
							<ul class="top_social">
							<?php if(!empty($content['c_facebook'])) : ?>
								<li>
								<a href="<?=$content['c_facebook']?>">
									<i class="ion-social-facebook"></i>
								</a>
								</li>
								<?php endif; ?>
								<?php if(!empty($content['c_twitter'])) : ?>
								<li>
								<a href="<?= $content['c_twitter'] ?>">
									<i class="ion-social-twitter"></i>
								</a>
								</li>
								<?php endif; ?>
								<?php if(!empty($content['c_instagram'])) : ?>
								<li>
								<a href="<?= $content['c_instagram'] ?>" >
									<i class="ion-social-instagram"></i>
								</a>
								</li>
								<?php endif; ?>
								<?php if(!empty($content['c_youtube'])) : ?>
								<li>
								<a href="<?= $content['c_youtube'] ?>" >
									<i class="ion-social-youtube"></i>
								</a>
								</li>
								<?php endif; ?>
								<?php if(!empty($content['c_discord'])) : ?>
								<li>
								<a href="<?= $content['c_discord'] ?>" >
									<i class="ion-social-discord"></i>
								</a>
								</li>
								<?php endif; ?>
								<?php if(!empty($content['c_linkedin'])) : ?>
								<li>
								<a href="<?= $content['c_linkedin'] ?>" >
									<i class="ion-social-linkedin"></i>
								</a>
								</li>
								<?php endif; ?>
								<?php if(!empty($content['c_mastodon'])) : ?>
								<li>
								<a href="<?= $content['c_mastodon'] ?>" >
									<i class="ion-social-mastodon"></i>
								</a>
								</li>
								<?php endif; ?>
								<?php if(!empty($content['c_email'])) : ?>
								<li>
								<a href="mailto:<?= $content['c_email'] ?>" >
									<i class="ion-email"></i>
								</a>
								</li>
								<?php endif; ?>
							</ul>
						</div>
						<div class="header_info">
							<div class="schedule">
								<img src="assets/images/clock.png" alt="schedule"> <div>Dnes: <a href="javascrip:void(0)">
								<span>
								<?php
									if(Utils::getActualDayOfWeek() == 'Monday')
									{
										if($content['mon_hour_start'])
											echo $content['mon_hour_start'] .':' . $content['mon_min_start'] . ' - '. $content['mon_hour_end'] . ':' . $content['mon_min_end'];												
										else
											echo '<span class="text-danger">Zavřeno</span>';

									}
									elseif(Utils::getActualDayOfWeek() == 'Tuesday')
									{
										if($content['tue_hour_start'])
											echo $content['tue_hour_start'] .':' . $content['tue_min_start'] . ' - '. $content['tue_hour_end'] . ':' . $content['tue_min_end'];												
										else
											echo '<span class="text-danger">Zavřeno</span>';

									}
									elseif(Utils::getActualDayOfWeek() == 'Wednesday')
									{
										if($content['wen_hour_start'])
											echo $content['wen_hour_start'] .':' . $content['wen_min_start'] . ' - '. $content['wen_hour_end'] . ':' . $content['wen_min_end'];												
										else
											echo '<span class="text-danger">Zavřeno</span>';

									}
									elseif(Utils::getActualDayOfWeek() == 'Thursday')
									{
										if($content['thu_hour_start'])
											echo $content['thu_hour_start'] .':' . $content['thu_min_start'] . ' - '. $content['thu_hour_end'] . ':' . $content['thu_min_end'];												
										else
											echo '<span class="text-danger">Zavřeno</span>';

									}
									elseif(Utils::getActualDayOfWeek() == 'Friday')
									{
										if($content['fri_hour_start'])
											echo $content['fri_hour_start'] .':' . $content['fri_min_start'] . ' - '. $content['fri_hour_end'] . ':' . $content['fri_min_end'];												
										else
											echo '<span class="text-danger">Zavřeno</span>';

									}
																					
									elseif(Utils::getActualDayOfWeek() == 'Saturday')
									{
										if($content['sat_hour_start'])
											echo $content['sat_hour_start'] .':' . $content['sat_min_start'] . ' - '. $content['sat_hour_end'] . ':' . $content['sat_min_end'];												
										else
											echo '<span class="text-danger">Na objednání</span>';
									} 
									elseif(Utils::getActualDayOfWeek() == 'Sunday')
									{
										if($content['sun_hour_start'])
											echo $content['sun_hour_start'] .':' . $content['sun_min_start'] . ' - '. $content['sun_hour_end'] . ':' . $content['sun_min_end'];												
										else
											echo '<span class="text-danger">Zavřeno</span>';

									}
								?>
								</span>
							</div>
							</div>
							<div class="phone">
								<img src="assets/images/phone.png" alt="phone">
								<div><span>Volejte</span><br><a href="tel:<?= $content['c_phone'] ?>" class="phone-special"><?= $content['c_phone'] ?></a></div>
							</div>
						</div>
					</div>
				</div>
			</div>
				
			<div class="middle_bar">
				<div class="container">
					<div class="middle_bar_inner">
						<div class="logo">
							<a href="*"><img src="assets/images/logo.png" alt="logo"></a>
						</div>

						<div class="header_right_part">
							<div class="mainnav">
								<ul class="main_menu">
									<li class="menu-item menu-item-has-children active"><a href="/">Úvod</a>
									</li>
									<li class="menu-item menu-item-has-children"><a href="#services">Služby</a></li>
									
									<li class="menu-item menu-item-has-children"><a href="#faq">Dotazy</a>
									</li>
									<li class="menu-item menu-item-has-children"><a href="#testimonial">Refecence</a>
									</li>
									<li class="menu-item menu-item-has-children"><a href="#contact">Kontakt</a>
									</li>
								</ul>
							</div>
							<div class="header_search">

							</div>
								
							<!-- mobile menu toggle button -->
							<div class="aside_open"><i class="ion-ios-keypad"></i></div>
							<button class="ma5menu__toggle" type="button">
								<i class="ion-android-menu"></i>
							</button>
						</div>
					</div>
				</div>
			</div>
		</header>

		<div class="main_wrapper">
			<div class="theme_slider_1">
                <div class="slider_slick_1">
                    <div class="item">
                        <div class="slider" style="background-image:url(assets/images/slider/slider_bg3.jpg)">
                            <div class="container">
                                <div class="row">
                                    <div class="col-lg-7">
                                        <div class="slide_content">
                                            <h3 class="sub_heading">Autorizovaný partner <span>FAB</span></h3>
											<h2 class="heading"><?= $content['hero_title']?></h2>
											<p class="desc"><?= $content['hero_subtitle']?></p>
                                            <div class="slider_button">
                                                <a href="#services" class="button alt">Další služby</a>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-lg-5">
                                        <div class="slide_content_img">
                                            
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
			</div>
			
			<div class="services" id="services">
				<div class="row">
					<div class="col-lg-4 col-md-6 col-lg-6 pd_0">
						<div class="iconbox3 first">
							<div class="iconbox_wrapper">
								<div class="iconbox_image">
									<div class="iconbox_icon">
										<i class="first_icon ion-wineglass"></i>
										<i class="second_icon ion-wineglass"></i>
									</div>
								</div>
								<div class="iconbox_content">
									<h3><a href="#contact">Pískování skla</a></h3>
									<p>Pískujeme sklenice na víno, whisky, sekt, koňak, pivo atd. Vyrobíme skvělý dárek pro Vaše blízké nebo obchodní partnery. </p>
									<div class="read_more">
										<a href="#contact"><span>Kontakt</span></a>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="col-lg-4 col-md-6 col-lg-6 pd_0">
						<div class="iconbox3 second h-100">
							<div class="iconbox_wrapper">
								<div class="iconbox_image">
									<div class="iconbox_icon">
										<i class="first_icon ion-printer"></i>
										<i class="second_icon ion-printer"></i>
									</div>
								</div>
								<div class="iconbox_content">
									<h3><a href="#contact">3D tisk & Polepy</a></h3>
									<p>Zvládáme 3D tisk a modelace na zakázku díky FDM a SLA tiskárnám. Poradíme si dokonce s polepy výloh a polepy aut.  </p>
									<div class="read_more">
										<a href="#contact"><span>Kontakt</span></a>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="col-lg-4 col-md-6 col-lg-6 pd_0">
						<div class="iconbox3 third h-100">
							<div class="iconbox_wrapper">
								<div class="iconbox_image">
									<div class="iconbox_icon">
										<i class="first_icon ion-scissors"></i>
										<i class="second_icon ion-scissors"></i>
									</div>
								</div>
								<div class="iconbox_content">
									<h3><a href="#contact">Broušení nožů a nůžek</a></h3>
									<p>Profesionální nářadí potřebuje profesionální péči. Nemusíte být profesionální kuchař, aby jste ocenili ostrý nůž v kuchyni. </p>
									<div class="read_more">
										<a href="#contact"><span>Kontakt</span></a>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="col-12 col-md-6 col-lg-6 pd_0">
						<div class="iconbox3 first h-100">
							<div class="iconbox_wrapper">
								<div class="iconbox_image">
									<div class="iconbox_icon">
										<i class="first_icon ion-android-car"></i>
										<i class="second_icon ion-android-car"></i>
									</div>
								</div>
								<div class="iconbox_content">
									<h3><a href="">Servis a oprava autoklíčů</a></h3>
									<p>Máte poškozený klíč od vašeho automobilu? Umíme ho opravit a nebo vyrobíme nový. </p>
									<div class="read_more">
										<a href="#contact"><span>Kontakt</span></a>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			
			<div class="experience bglayer_1 pd_tp_110" id="about">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-6 col-md-4">
							<div class="group_image_holder type_1">
								<div class="expe_box">
									<div class="expe_box_inner">
										<h1>24/7</h1> 										
									</div>
								</div>
								<img class="main_img" src="assets/images/image6.jpg" alt="">
								<img class="sub_img" src="assets/images/image5.jpg" alt="">
								<img class="sub_img2" src="assets/images/image3.jpg" alt="">
							</div>
						</div>
                        <div class="col-lg-6 col-md-7">
							<div class="experience_content">
								<div class="section_header" data-aos="fade-up">
									<i class="shadow_icon ion-unlocked"></i>
									<h6 class="section_sub_title">Provádíme</h6>
									<h1 class="section_title">Nouzové otevírání bytů</h1>
									<p class="section_desc">Otevřeme nouzově jakýkoliv zámek. Víme, že když se nemůžete dostat do svého domova, je to pro vás stresující situace. Proto 
										<span class="trademarks"> garantujeme rychlou reakci a účinnou pomoc.</span> Nemusíte se strachovat, stačí jen zavolat a my přijedeme na pomoc. 
										V případě potřeby jsme připraveni okamžitě vyjet. Zavolejte nám a my se postaráme o vše ostatní.
									
									</p>
										<h5 class="appoint"><span>Nonstop pohotovostní služba</span></h5>
								</div>
								<div class="read_more" data-aos="fade-up">
									<a class="button" href="tel:<?= $content['c_phone'] ?>"><i class="ion-ios-telephone"></i><?= $content['c_phone'] ?></a>
								</div>
							</div>
                        </div>
                    </div>
                </div>
			</div>
			<div class="bglayer_1" >
                <div class="container pb-5">
                    <div class="row pb-5">
                        
                        <div class="col-lg-6 col-md-7">
							<div class="experience_content">
								<div class="section_header" data-aos="fade-up">									
									<h6 class="section_sub_title">Systémy generálního klíče</h6>
									<h1 class="section_title">Instalujeme SGHK sytémy</h1>
									<p class="section_desc">V rámci SGHK<span class="trademarks"> (systém generálního a hlavního klíče) </span> obdrží každá osoba klíč, kterým odemkne pouze takové dveře, ke kterým má oprávnění.
										Jedná se o přehledný systém pro správu klíčů a řízení přístupu. 
									
									<ul>
										<li class="section_desc">
											Komfortní odemykání více dveří jediným klíčem
										</li>
										<li class="section_desc">Menší počet klíčů</li>
										<li class="section_desc">Jednoduchá správa klíčů</li>
										<li class="section_desc">Zamezení "toulání" nepovolaných osob na pracovišti</li>
									</ul>
									</p>
										<h5 class="appoint">Máte dotaz? <span><?= $content['c_phone'] ?></span></h5>
								</div>
								<div class="read_more" data-aos="fade-up">
									<a class="button" href="#contact">Kontakt</a>
								</div>
							</div>
                        </div>
						<div class="col-lg-6 col-md-4">
							<div class="d-flex flex-column justify-content-center align-items-center">
								<div class="expe_box d-none d-lg-block">
									<div class="expe_box_inner">
										<h1>SGHK</h1> 
										systémy
									</div>
								</div>
								<img class="main_img" src="assets/images/image7.jpg" alt="" class="image-responsive">								
							</div>
						</div>
                    </div>
                </div>
			</div>

			<div class="funfacts bg_image_3">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-9">
                            <div class="section_header" data-aos="fade-up">
								<h6 class="section_sub_title">Bezpečí pro Váš domov</h6>
								<h1 class="section_title">Bezpečnostní vložky<br/>
									proti vloupání</h1>
								<p class="section_desc">Nabízíme certifikované cylindrické vložky se 3. a 4. 
									bezpečnostní třídou určené k zabezpečení bytů, kanceláří, provozoven, garáží, 
									rekreačních objektů, rodinných a bytových domů.</p>
							</div>
                            <div class="row">
                                <div class="col-lg-4 col-sm-6">
                                    <div class="funbox1">
                                        <div class="fun_img">
                                            <i class="ion-trophy"></i>
                                        </div>
                                        <div class="fun_content">
                                            <h1><span class="fun-number">5</span></h1>
                                            <p>Let zkušenosti</p>
                                        </div>
                                    </div>
                                </div>  
                                
                                <div class="col-lg-4 col-sm-6">
                                    <div class="funbox1">
                                        <div class="fun_img">
                                            <i class="ion-key"></i>
                                        </div>
                                        <div class="fun_content">
                                            <h1><span class="fun-number">20</span>k+</h1>
                                            <p>Duplikátů ztracených klíčů</p>
                                        </div>
                                    </div>
                                </div>  
                                
                                <div class="col-lg-4 col-sm-6">
                                    <div class="funbox1">
                                        <div class="fun_img">
                                            <i class="ion-locked"></i>
                                        </div>
                                        <div class="fun_content">
                                            <h1><span class="fun-number">1</span>k+</h1>
                                            <p>Vyměněných zámků</p>
                                        </div>
                                    </div>
                                </div> 
                            </div>
                        </div>
                        <div class="col-lg-3">
                            <div class="man_img">
                                <img src="assets/images/key.png" alt="icon">
                            </div>
                        </div>
                    </div>
                </div>
			</div>

			<div class="main_wrapper" id="faq">
				<div class="section faq">
					<div class="container">
						<div class="row">
							<div class="col-lg-4 col-md-12">
								<div class="faq_imgbox" data-aos="fade-right">
									<img src="assets/images/support.png" alt="Faq">
								</div>
							</div>
							<div class="col-lg-8 col-md-7">
								<div class="section_header" data-aos="fade-up">
									<h6 class="section_sub_title">Faq</h6>
									<h1 class="section_title">Časté dotazy se kterými se setkáváme</h1>
								</div>
								<div class="accordion" data-aos="fade-up">
								<?php $i= 1; ?>
								<?php foreach($faqs as $faq) : ?>
									<div class="item">
										<div class="accordion_tab">
											<h2 class="accordion_title"><span><?= $i ?>.</span><?= $faq['faq_question'] ?> </h2>
											<span class="accordion_tab_icon">
												<i class="open_icon ion-android-add"></i>
												<i class="close_icon ion-android-remove"></i>
											</span>
										</div>
										<div class="accordion_info">
											<?= $faq['faq_answer'] ?>
										</div>
									</div>
									<?php $i++; ?>
									<?php endforeach; ?>
			
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="banner" data-aos="fade-up">
					<div class="banner_content">
						<div class="container">
							<div class="row">
								<div class="col-lg-7">
									<div class="banner_text">
										<h1><?= $content['cta_title'] ?></h1>
									</div>
								</div>
								<div class="col-lg-5">
									<div class="banner_phone">
										<img src="assets/images/phone.png" alt="">
										<a href="tel:<?= $content['c_phone'] ?>" class="phone-special"><?= $content['c_phone'] ?></a>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>



			<div class="section testimonial" id="testimonial">
				<div class="container">
					<div class="section_header text-center" data-aos="fade-up">
						<div class="shadow_icon"></div>
						<h6 class="section_sub_title">Klientům nasloucháme</h6>
						<h1 class="section_title">Hodnocení našich zákazníků</h1>
						<p class="section_desc">Chceme se neustále zlepšovat a posouvat naše služby směrem k zákazníkům.<br>
							Proto je Váš názor pro nás důležitý. <a href="#contact">Napiště nám ho.</a>
						</p>
					</div>
					<div class="testimonial_slick_1">
						<div class="item">
							<div class="testibox1">
								<div class="testibox_inner">
									<div class="testi-content">
										<ul>
											<li class="text">Hodnocení:</li>
											<li><i class="ion-ios-star"></i></li>
											<li><i class="ion-ios-star"></i></li>
											<li><i class="ion-ios-star"></i></li>
											<li><i class="ion-ios-star"></i></li>
											<li><i class="ion-ios-star"></i></li>
										</ul>
										<p>Po nepříjemné situaci kdy naší zahradní chatku navštívil zloděj, 
											jsem si zde nechala poradit a byla jsem mile překvapena, jak účinně se lze bránit.</p>
									</div>
									<div class="testi-top">
										<div class="testi-img">
											<img src="https://www.stanislav-drako.cz/klice/assets/images/reviewer1.jpeg" alt="">
										</div>
										<div class="testi-info">
											<h4>Jana Nováková</h4>
											<h6>Dolní Lutyně</h6>
										</div>
									</div>
								</div>
                            </div>
						</div>
						<div class="item">
							<div class="testibox1">
								<div class="testibox_inner">
									<div class="testi-content">
										<ul>
											<li class="text">Hodnocení:</li>
											<li><i class="ion-ios-star"></i></li>
											<li><i class="ion-ios-star"></i></li>
											<li><i class="ion-ios-star"></i></li>
											<li><i class="ion-ios-star"></i></li>
											<li><i class="ion-ios-star-half"></i></li>
										</ul>
										<p>Ztratil jsem celý svazek klíčů a potřeboval vyměnit všechny zámky v celé provozovně (cca 25 dvěří). Naštěstí to šlo rychleji než jsem čekal.</p>
									</div>
									<div class="testi-top">
										<div class="testi-img">
											<img src="https://www.stanislav-drako.cz/klice/assets/images/reviewer2.jpeg" alt="">
										</div>
										<div class="testi-info">
											<h4>Jiří Drahota</h4>
											<h6>Bohumín</h6>
										</div>
									</div>
								</div>
                            </div>
						</div>
						<div class="item">
							<div class="testibox1">
								<div class="testibox_inner">
									<div class="testi-content">
										<ul>
											<li class="text">Hodnocení:</li>
											<li><i class="ion-ios-star"></i></li>
											<li><i class="ion-ios-star"></i></li>
											<li><i class="ion-ios-star"></i></li>
											<li><i class="ion-ios-star"></i></li>
											<li><i class="ion-ios-star"></i></li>
										</ul>
										<p>Nechala jsem si zde pískovat jména na šampusové skleničky jako firemní dárek pro své zaměstnance. 
											Teď má na firemním večírku každý svou vlastní skleničku :)</p>
									</div>
									<div class="testi-top">
										<div class="testi-img">
											<img src="https://www.stanislav-drako.cz/klice/assets/images/reviewer3.jpeg" alt="">
										</div>
										<div class="testi-info">
											<h4>Eva Křižánková</h4>
											<h6>Bohumín</h6>
										</div>
									</div>
								</div>
                            </div>
						</div>

					</div>
				</div>
			</div>
			
			<div class="clients type_2" data-aos="fade-up">
				<div class="clients_content">
					<div class="row">
						<div class="col-lg-2 col-md-2 col-sm-4 client_logo">
							<img src="assets/images/company/logo1.png" alt="">
						</div>
						<div class="col-lg-2 col-md-2 col-sm-4 client_logo">
							<img src="assets/images/company/logo2.png" alt="">
						</div>
						<div class="col-lg-2 col-md-2 col-sm-4 client_logo">
							<img src="assets/images/company/logo3.png" alt="">
						</div>
						<div class="col-lg-2 col-md-2 col-sm-4 client_logo">
							<img src="assets/images/company/logo4.png" alt="">
						</div>
						<div class="col-lg-2 col-md-2 col-sm-4 client_logo">
							<img src="assets/images/company/logo5.png" alt="">
						</div>
						<div class="col-lg-2 col-md-2 col-sm-4 client_logo">
							<img src="assets/images/company/logo6.png" alt="">
						</div>
					</div>
                </div>
			</div>
			
			<div class="blog section">
                <div class="container">
                    <div class="blog_grid overflow-hidden">
						<div class="row g-5">
							<div class="col-12 text-center">
								<div class="col-lg-8 mx-auto">
								<div class="section_header" data-aos="fade-up">
									<h6 class="section_sub_title">Mohlo by Vás zajímat</h6>
									<h1 class="section_title">Pro větší bezpečnost</h1>
									<p class="section_desc">Všude tam, kde je potřeba zabezpečit majetek 
										větší hodnoty používejte vždy bezpečnostní vložky s minimální certifikací III, ideálně IV. 
										Většina vložek je dostupná ve více rozměrech, proto je před nákupem důležité správně změřit 
										velikost a délku cylindrické vložky.
									</p>
									<p class="section_desc">
										Vyzkoušejte náš vlastní profil STAR 100S TM <i class="ion-android-arrow-down ps-1"></i>
									</p>
								</div>
								<div class="read_more" data-aos="fade-up">
									<a class="button" href="#faq">Jak změřit vložku?</a>
								</div>
								</div>
							</div>
							<div class="col-12">
								<div class="row  pt-5 g-5">
								<div class=" col-sm-6 col-lg-4">
								<article class="blog_post h-100">
									<div class="post_img">
										<a href="javascript:void(0)"><img src="https://www.stanislav-drako.cz/klice/assets/images/product1.webp" alt="img"></a>
										<div class="calendar">
											<a href="#"><span class="date"></span><br>TOP</a>
										</div>
									</div>
									<div class="post_content">
										<div class="post_header">
											<h3 class="post_title">
												<a href="#">Bezpečnostní vložka STAR 100S TM</a>
											</h3>
										</div>
										<div class="post_intro">
											<p>Cylindrická vložka se vkládá do dveří, které mají zabránit přístupu zlodějům. 
												III. bezpečnostní třída. V balení najdete 5ks klíčů. Délka vložky je ve více variantách.</p>
										</div>
										<div class="post_footer">
											<div class="read_more">
												<a href="#contact"><span>Koupit na prodejně</span></a>
											</div>
										</div>
									</div>
								</article>
								</div>
								<div class="col-sm-6 col-lg-4">
									<article class="blog_post h-100">
										<div class="post_img">
											<a href="javasrcipt:void(0)"><img src="https://www.stanislav-drako.cz/klice/assets/images/product2.webp" alt="img"></a>
											<div class="calendar">
												<a href="#"><span class="date"></span><br>TIP</a>
											</div>
										</div>
										<div class="post_content">
											<div class="post_header">
												<h3 class="post_title">
													<a href="#">Samolepící rozlišovače na klíče</a>
												</h3>
											</div>
											<div class="post_intro">
												<p>Skvělý způsob, jak zlepšit organizaci vašich klíčů. Tyto samolepící štítky mohou být snadno nalepeny na jakýkoli klíč a navíc jsou odolné proti vodě a oděru.</p>
											</div>
											<div class="post_footer">
												<div class="read_more">
													<a href="#contact"><span>Koupit na prodejně</span></a>
													
													<a href="assets/images/samolepici_rozlisovace.pdf" target="_blank"><span>Zakázková výroba</span></a>
												</div>
											</div>
										</div>
									</article>
									</div>
								</div>
							</div>

						</div>
					</div>
                </div>
			</div>
		</div>

		
		<!-- Footer 1 -->
		<footer class="footer" data-aos="fade-up" id="contact">
            <div class="footer_above">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-3 col-sm-6 pd_0">
                            <div class="footer_widget footer_links" data-aos="fade-up" data-aos-duration="1200">
                                <h4 class="widget_title">
									Rychlé odkazy
									<span class="title_line"></span>
                                </h4>
                                <div class="footer_nav">
                                    <ul class="footer_menu">
                                        <li class="menu-item"><a href="#services">Služby</a></li>
                                        
                                        <li class="menu-item"><a href="#faq">Dotazy</a></li>
                                        <li class="menu-item"><a href="#testimonial">Reference</a></li>
                                        <li class="menu-item"><a href="#contact">Kontakt</a></li>
                                    </ul>
                                </div>
                            </div>
						</div>
						<div class="col-lg-6 col-sm-6 pd_lr_65">
                            <div class="footer_widget footer_contact" data-aos="fade-up" data-aos-duration="900">
								<div class="logo_footer">
									<a href="index.html">
										<img src="assets/images/logo.png" alt="Klíče Brejcha">
									</a>
								</div>
								<div class="contact_info">
									<h4><a href="mailto:<?= $content['c_email'] ?>"><?= $content['c_email'] ?></a></h4>
									<h4><?= $content['c_address'] ?></h4>
									<div class="phone">
										<i class="ion-ios-telephone"></i>
										
										<div><span>Dnes:
											<?php
												if(Utils::getActualDayOfWeek() == 'Monday')
												{
													if($content['mon_hour_start'])
														echo $content['mon_hour_start'] .':' . $content['mon_min_start'] . ' - '. $content['mon_hour_end'] . ':' . $content['mon_min_end'];												
													else
														echo '<span class="text-danger">Zavřeno</span>';

												}
												elseif(Utils::getActualDayOfWeek() == 'Tuesday')
												{
													if($content['tue_hour_start'])
														echo $content['tue_hour_start'] .':' . $content['tue_min_start'] . ' - '. $content['tue_hour_end'] . ':' . $content['tue_min_end'];												
													else
														echo '<span class="text-danger">Zavřeno</span>';

												}
												elseif(Utils::getActualDayOfWeek() == 'Wednesday')
												{
													if($content['wen_hour_start'])
														echo $content['wen_hour_start'] .':' . $content['wen_min_start'] . ' - '. $content['wen_hour_end'] . ':' . $content['wen_min_end'];												
													else
														echo '<span class="text-danger">Zavřeno</span>';

												}
												elseif(Utils::getActualDayOfWeek() == 'Thursday')
												{
													if($content['thu_hour_start'])
														echo $content['thu_hour_start'] .':' . $content['thu_min_start'] . ' - '. $content['thu_hour_end'] . ':' . $content['thu_min_end'];												
													else
														echo '<span class="text-danger">Zavřeno</span>';

												}
												elseif(Utils::getActualDayOfWeek() == 'Friday')
												{
													if($content['fri_hour_start'])
														echo $content['fri_hour_start'] .':' . $content['fri_min_start'] . ' - '. $content['fri_hour_end'] . ':' . $content['fri_min_end'];												
													else
														echo '<span class="text-danger">Zavřeno</span>';

												}
																								
												elseif(Utils::getActualDayOfWeek() == 'Saturday')
												{
													if($content['sat_hour_start'])
														echo $content['sat_hour_start'] .':' . $content['sat_min_start'] . ' - '. $content['sat_hour_end'] . ':' . $content['sat_min_end'];												
													else
														echo '<span class="text-danger">Na objednání</span>';
												} 
												elseif(Utils::getActualDayOfWeek() == 'Sunday')
												{
													if($content['sun_hour_start'])
														echo $content['sun_hour_start'] .':' . $content['sun_min_start'] . ' - '. $content['sun_hour_end'] . ':' . $content['sun_min_end'];												
													else
														echo '<span class="text-danger">Zavřeno</span>';

												}
											?>
											</span>
										<br><a href="tel:<?= $content['c_phone'] ?>"><?= $content['c_phone'] ?></a></div>
									</div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-sm-6 pd_0">
                            <div class="footer_widget" data-aos="fade-up" data-aos-duration="1500">
                                <h4 class="widget_title">
									Provozní doba
									<span class="title_line"></span>
                                </h4>

								<?php if(!$content['nonstop']) :  ?> 
          
								                         
									<div class="d-flex justify-content-between">
										<div class="widget_item"><span>Pondělí: </span></div>
										<?php if($content['mon_hour_start']) : ?>
										<div class="d-flex gap-2 text-white">
											<div><span><?= $content['mon_hour_start'] ?></span> : <span><?= $content['mon_min_start'] ?></span></div>
											<div> - <span><?= $content['mon_hour_end'] ?></span> : <span><?= $content['mon_min_end'] ?></span></div>
										</div>
										<?php else : ?>
										<div><span class="text-danger">Zavřeno</span></div>
										<?php endif; ?>
									</div> 
									<div class="d-flex justify-content-between">
									<div class="widget_item"><span class="headline-color">Úterý: </span></div>
										<?php if($content['tue_hour_start']) : ?>
										<div class="d-flex gap-2 text-white">
											<div><span><?= $content['tue_hour_start'] ?></span> : <span><?= $content['tue_min_start'] ?></span></div>
											<div> - <span><?= $content['tue_hour_end'] ?></span> : <span><?= $content['tue_min_end'] ?></span></div>
										</div>
										<?php else : ?>
										<div><span class="text-danger">Zavřeno</span></div>
										<?php endif; ?>
									</div>
									<div class="d-flex justify-content-between">
									<div class="widget_item"><span class="headline-color">Středa: </span></div>
										<?php if($content['wen_hour_start']) : ?>
										<div class="d-flex gap-2 text-white">
											<div><span><?= $content['wen_hour_start'] ?></span> : <span><?= $content['wen_min_start'] ?></span></div>
											<div> - <span><?= $content['wen_hour_end'] ?></span> : <span><?= $content['wen_min_end'] ?></span></div>
										</div>
										<?php else : ?>
										<div><span class="text-danger">Zavřeno</span></div>
										<?php endif; ?>
									</div>     
									<div class="d-flex justify-content-between">
									<div class="widget_item"><span class="headline-color">Čtvrtek: </span></div>
										<?php if($content['thu_hour_start']) : ?>
										<div class="d-flex gap-2 text-white">
											<div><span><?= $content['thu_hour_start'] ?></span> : <span><?= $content['thu_min_start'] ?></span></div>
											<div> - <span><?= $content['thu_hour_end'] ?></span> : <span><?= $content['thu_min_end'] ?></span></div>
										</div>
										<?php else : ?>
										<div><span class="text-danger">Zavřeno</span></div>
										<?php endif; ?>
									</div>
									<div class="d-flex justify-content-between">
									<div class="widget_item"><span class="headline-color">Pátek: </span></div>
										<?php if($content['fri_hour_start']) : ?>
										<div class="d-flex gap-2 text-white">
											<div><span><?= $content['fri_hour_start'] ?></span> : <span><?= $content['fri_min_start'] ?></span></div>
											<div> - <span><?= $content['fri_hour_end'] ?></span> : <span><?= $content['fri_min_end'] ?></span></div>
										</div>
										<?php else : ?>
										<div><span class="text-danger">Zavřeno</span></div>
										<?php endif; ?>
									</div> 
									<div class="d-flex justify-content-between">
									<div class="widget_item"><span class="headline-color">Sobota: </span></div>
										<?php if($content['sat_hour_start']) : ?>
										<div class="d-flex gap-2 text-white">
											<div><span><?= $content['sat_hour_start'] ?></span> : <span><?= $content['sat_min_start'] ?></span></div>
											<div> - <span><?= $content['sat_hour_end'] ?></span> : <span><?= $content['sat_min_end'] ?></span></div>
										</div>
										<?php else : ?>
										<div><span class="text-danger">Na objednání</span></div>
										<?php endif; ?>
									</div>                                                                     
									<div class="d-flex justify-content-between">
									<div class="widget_item"><span class="headline-color">Neděle: </span></div>
										<?php if($content['sun_hour_start']) : ?>
										<div class="d-flex gap-2 text-white">
											<div><span><?= $content['sun_hour_start'] ?></span> : <span><?= $content['sun_min_start'] ?></span></div>
											<div> - <span><?= $content['sun_hour_end'] ?></span> : <span><?= $content['sun_min_end'] ?></span></div>
										</div>
										<?php else : ?>
										<div><span class="text-danger">Zavřeno</span></div>
										<?php endif; ?>
									</div> 
								
							
								<?php endif; ?>
								<div>
								</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="footer_bottom">
                <div class="container-fluid">
                    <div class="footer_bottom_inner">
                        <div class="copyright">
                            <p>&copy2020 - <?= date('Y') ?> Vytvořil s láskou <a href="https://www.stanislav-drako.cz">Stanislav Drako</a></p>
						</div>
						<div class="footer_social">
							<ul class="bottom_social">
							<?php if(!empty($content['c_facebook'])) : ?>
								<li>
								<a href="<?=$content['c_facebook']?>">
									<i class="ion-social-facebook"></i>
								</a>
								</li>
								<?php endif; ?>
								<?php if(!empty($content['c_twitter'])) : ?>
								<li>
								<a href="<?= $content['c_twitter'] ?>">
									<i class="ion-social-twitter"></i>
								</a>
								</li>
								<?php endif; ?>
								<?php if(!empty($content['c_instagram'])) : ?>
								<li>
								<a href="<?= $content['c_instagram'] ?>" >
									<i class="ion-social-instagram"></i>
								</a>
								</li>
								<?php endif; ?>
								<?php if(!empty($content['c_youtube'])) : ?>
								<li>
								<a href="<?= $content['c_youtube'] ?>" >
									<i class="ion-social-youtube"></i>
								</a>
								</li>
								<?php endif; ?>
								<?php if(!empty($content['c_discord'])) : ?>
								<li>
								<a href="<?= $content['c_discord'] ?>" >
									<i class="ion-social-discord"></i>
								</a>
								</li>
								<?php endif; ?>
								<?php if(!empty($content['c_linkedin'])) : ?>
								<li>
								<a href="<?= $content['c_linkedin'] ?>" >
									<i class="ion-social-linkedin"></i>
								</a>
								</li>
								<?php endif; ?>
								<?php if(!empty($content['c_mastodon'])) : ?>
								<li>
								<a href="<?= $content['c_mastodon'] ?>" >
									<i class="ion-social-mastodon"></i>
								</a>
								</li>
								<?php endif; ?>
								<?php if(!empty($content['c_email'])) : ?>
								<li>
								<a href="mailto:<?= $content['c_email'] ?>" >
									<i class="ion-email"></i>
								</a>
								</li>
								<?php endif; ?>
							</ul>
						</div>
						<div class="totop">
                            <a href="#"><i class="ion-ios-arrow-up"></i></a>
                        </div>
                    </div>
                </div>
            </div>
        </footer>

		<div class="slide_navi">
			<div class="side_contact_info">
				<h4><a href="mailto:<?= $content['c_email'] ?>"><?= $content['c_email'] ?></a></h4>
				<h4><?= $content['c_address'] ?></h4>
				<div class="phone flex-column">
					<i class="ion-ios-telephone"></i>
					<div>
						<span>Dnes:
						<?php
							if(Utils::getActualDayOfWeek() == 'Monday')
							{
								if($content['mon_hour_start'])
									echo $content['mon_hour_start'] .':' . $content['mon_min_start'] . ' - '. $content['mon_hour_end'] . ':' . $content['mon_min_end'];												
								else
									echo '<span class="text-danger">Zavřeno</span>';

							}
							elseif(Utils::getActualDayOfWeek() == 'Tuesday')
							{
								if($content['tue_hour_start'])
									echo $content['tue_hour_start'] .':' . $content['tue_min_start'] . ' - '. $content['tue_hour_end'] . ':' . $content['tue_min_end'];												
								else
									echo '<span class="text-danger">Zavřeno</span>';

							}
							elseif(Utils::getActualDayOfWeek() == 'Wednesday')
							{
								if($content['wen_hour_start'])
									echo $content['wen_hour_start'] .':' . $content['wen_min_start'] . ' - '. $content['wen_hour_end'] . ':' . $content['wen_min_end'];												
								else
									echo '<span class="text-danger">Zavřeno</span>';

							}
							elseif(Utils::getActualDayOfWeek() == 'Thursday')
							{
								if($content['thu_hour_start'])
									echo $content['thu_hour_start'] .':' . $content['thu_min_start'] . ' - '. $content['thu_hour_end'] . ':' . $content['thu_min_end'];												
								else
									echo '<span class="text-danger">Zavřeno</span>';

							}
							elseif(Utils::getActualDayOfWeek() == 'Friday')
							{
								if($content['fri_hour_start'])
									echo $content['fri_hour_start'] .':' . $content['fri_min_start'] . ' - '. $content['fri_hour_end'] . ':' . $content['fri_min_end'];												
								else
									echo '<span class="text-danger">Zavřeno</span>';

							}
																			
							elseif(Utils::getActualDayOfWeek() == 'Saturday')
							{
								if($content['sat_hour_start'])
									echo $content['sat_hour_start'] .':' . $content['sat_min_start'] . ' - '. $content['sat_hour_end'] . ':' . $content['sat_min_end'];												
								else
									echo '<span class="text-danger">Na objednání</span>';
							} 
							elseif(Utils::getActualDayOfWeek() == 'Sunday')
							{
								if($content['sun_hour_start'])
									echo $content['sun_hour_start'] .':' . $content['sun_min_start'] . ' - '. $content['sun_hour_end'] . ':' . $content['sun_min_end'];												
								else
									echo '<span class="text-danger">Zavřeno</span>';

							}
						?>

						</span>
					<br><?= $content['c_phone'] ?></div>
				</div>
			</div>
			<div class="side_footer_social">
				<ul class="bottom_social">
				<?php if(!empty($content['c_facebook'])) : ?>
					<li>
					<a href="<?=$content['c_facebook']?>">
						<i class="ion-social-facebook"></i>
					</a>
					</li>
					<?php endif; ?>
					<?php if(!empty($content['c_twitter'])) : ?>
					<li>
					<a href="<?= $content['c_twitter'] ?>">
						<i class="ion-social-twitter"></i>
					</a>
					</li>
					<?php endif; ?>
					<?php if(!empty($content['c_instagram'])) : ?>
					<li>
					<a href="<?= $content['c_instagram'] ?>" >
						<i class="ion-social-instagram"></i>
					</a>
					</li>
					<?php endif; ?>
					<?php if(!empty($content['c_youtube'])) : ?>
					<li>
					<a href="<?= $content['c_youtube'] ?>" >
						<i class="ion-social-youtube"></i>
					</a>
					</li>
					<?php endif; ?>
					<?php if(!empty($content['c_discord'])) : ?>
					<li>
					<a href="<?= $content['c_discord'] ?>" >
						<i class="ion-social-discord"></i>
					</a>
					</li>
					<?php endif; ?>
					<?php if(!empty($content['c_linkedin'])) : ?>
					<li>
					<a href="<?= $content['c_linkedin'] ?>" >
						<i class="ion-social-linkedin"></i>
					</a>
					</li>
					<?php endif; ?>
					<?php if(!empty($content['c_mastodon'])) : ?>
					<li>
					<a href="<?= $content['c_mastodon'] ?>" >
						<i class="ion-social-mastodon"></i>
					</a>
					</li>
					<?php endif; ?>
					<?php if(!empty($content['c_email'])) : ?>
					<li>
					<a href="mailto:<?= $content['c_email'] ?>" >
						<i class="ion-email"></i>
					</a>
					</li>
					<?php endif; ?>
				</ul>
			</div>
		</div>

		
		<div class="aside_info">
			<div class="aside_close"><img src="assets/images/close.png" alt="icon"></div>
			<div class="logo-side">
				<a href="/">
					<img src="assets/images/logo.png" alt="Hashtag">
				</a>
			</div>
			<div class="side_info">
				<h3>
					O nás
					<span class="title_line"></span>
				</h3>
				<p>Nabízíme širokou škálu zamykacích systémů, cylindrických vložek, 
					zámků, bezpečnostního příslušenství ke dveřím a řadu doplňkových produktů. Výroba všech druhů klíčů je samozřejmostí.</p>
			</div>
			<div class="side_footer_social">
				<ul class="bottom_social">
				<?php if(!empty($content['c_facebook'])) : ?>
					<li>
					<a href="<?=$content['c_facebook']?>">
						<i class="ion-social-facebook"></i>
					</a>
					</li>
					<?php endif; ?>
					<?php if(!empty($content['c_twitter'])) : ?>
					<li>
					<a href="<?= $content['c_twitter'] ?>">
						<i class="ion-social-twitter"></i>
					</a>
					</li>
					<?php endif; ?>
					<?php if(!empty($content['c_instagram'])) : ?>
					<li>
					<a href="<?= $content['c_instagram'] ?>" >
						<i class="ion-social-instagram"></i>
					</a>
					</li>
					<?php endif; ?>
					<?php if(!empty($content['c_youtube'])) : ?>
					<li>
					<a href="<?= $content['c_youtube'] ?>" >
						<i class="ion-social-youtube"></i>
					</a>
					</li>
					<?php endif; ?>
					<?php if(!empty($content['c_discord'])) : ?>
					<li>
					<a href="<?= $content['c_discord'] ?>" >
						<i class="ion-social-discord"></i>
					</a>
					</li>
					<?php endif; ?>
					<?php if(!empty($content['c_linkedin'])) : ?>
					<li>
					<a href="<?= $content['c_linkedin'] ?>" >
						<i class="ion-social-linkedin"></i>
					</a>
					</li>
					<?php endif; ?>
					<?php if(!empty($content['c_mastodon'])) : ?>
					<li>
					<a href="<?= $content['c_mastodon'] ?>" >
						<i class="ion-social-mastodon"></i>
					</a>
					</li>
					<?php endif; ?>
					<?php if(!empty($content['c_email'])) : ?>
					<li>
					<a href="mailto:<?= $content['c_email'] ?>" >
						<i class="ion-email"></i>
					</a>
					</li>
					<?php endif; ?>
				</ul>
			</div>
			<div class="side_contact_info">
				<h4><a href="mailto:<?= $content['c_email'] ?>"><?= $content['c_email'] ?></a></h4>
				<h4><?= $content['c_address'] ?></h4>
				<div class="phone">
					<i class="ion-ios-telephone"></i>
					<div>
						<span>Dnes : <?php
									if(Utils::getActualDayOfWeek() == 'Monday')
									{
										if($content['mon_hour_start'])
											echo $content['mon_hour_start'] .':' . $content['mon_min_start'] . ' - '. $content['mon_hour_end'] . ':' . $content['mon_min_end'];												
										else
											echo '<span class="text-danger">Zavřeno</span>';

									}
									elseif(Utils::getActualDayOfWeek() == 'Tuesday')
									{
										if($content['tue_hour_start'])
											echo $content['tue_hour_start'] .':' . $content['tue_min_start'] . ' - '. $content['tue_hour_end'] . ':' . $content['tue_min_end'];												
										else
											echo '<span class="text-danger">Zavřeno</span>';

									}
									elseif(Utils::getActualDayOfWeek() == 'Wednesday')
									{
										if($content['wen_hour_start'])
											echo $content['wen_hour_start'] .':' . $content['wen_min_start'] . ' - '. $content['wen_hour_end'] . ':' . $content['wen_min_end'];												
										else
											echo '<span class="text-danger">Zavřeno</span>';

									}
									elseif(Utils::getActualDayOfWeek() == 'Thursday')
									{
										if($content['thu_hour_start'])
											echo $content['thu_hour_start'] .':' . $content['thu_min_start'] . ' - '. $content['thu_hour_end'] . ':' . $content['thu_min_end'];												
										else
											echo '<span class="text-danger">Zavřeno</span>';

									}
									elseif(Utils::getActualDayOfWeek() == 'Friday')
									{
										if($content['fri_hour_start'])
											echo $content['fri_hour_start'] .':' . $content['fri_min_start'] . ' - '. $content['fri_hour_end'] . ':' . $content['fri_min_end'];												
										else
											echo '<span class="text-danger">Zavřeno</span>';

									}
																					
									elseif(Utils::getActualDayOfWeek() == 'Saturday')
									{
										if($content['sat_hour_start'])
											echo $content['sat_hour_start'] .':' . $content['sat_min_start'] . ' - '. $content['sat_hour_end'] . ':' . $content['sat_min_end'];												
										else
											echo '<span class="text-danger">Na objednání</span>';
									} 
									elseif(Utils::getActualDayOfWeek() == 'Sunday')
									{
										if($content['sun_hour_start'])
											echo $content['sun_hour_start'] .':' . $content['sun_min_start'] . ' - '. $content['sun_hour_end'] . ':' . $content['sun_min_end'];												
										else
											echo '<span class="text-danger">Zavřeno</span>';

									}
								?> </span>
						<br><?= $content['c_phone'] ?></div>
				</div>
			</div>
		</div>
		
        <!-- All JavaScript Files -->
		<script src="assets/js/jquery-3.5.1.min.js"></script>
        <script src="assets/js/popper.min.js"></script>
		<script src="assets/js/bootstrap.min.js"></script>
		
		<script src="assets/plugins/menu/ma5-menu.min.js"></script>
		<script src="assets/plugins/aos/aos.js"></script>
		<script src="assets/plugins/slick/slick.min.js"></script>
		<script src="assets/plugins/fancybox/jquery.fancybox.min.js"></script>

        <script src="assets/js/custom.js"></script>
	</body>
</html>
