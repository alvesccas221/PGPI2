<?php
use ycd\AdminHelper;
$contactFormUrl = AdminHelper::getPluginActivationUrl('contact-form-master');
$expandMaker = AdminHelper::getPluginActivationUrl('expand-maker');
$downloaderURL = AdminHelper::getPluginActivationUrl('ydn-download');
$scrollToTop = AdminHelper::getPluginActivationUrl('scroll-to-top-builder');
$randomNumbers = AdminHelper::getPluginActivationUrl('random-numbers-builder');
?>
<div class="plugin-group" id="ycd-plugins-wrapper">
	<div class="plugin-card">
		<div class="plugin-card-top">
			<a href="https://wordpress.org/plugins/random-numbers-builder/" target="_blank" class="plugin-icon"><div class="plugin-icon" id="plugin-icon-random-numbers"></div></a>
			<div class="name column-name">
				<h4>
					<a href="https://wordpress.org/plugins/random-numbers-builder/" target="_blank">Random numbers – WordPress Random numbers builder plugin</a>
					<div class="action-links">
				 		<span class="plugin-action-buttons">
					 		<a class="install-now button" data-slug="countdown-builder" href="<?php echo $randomNumbers; ?>">Install Now</a>
					 	</span>
					</div>
				</h4>
			</div>
			<div class="desc column-description">
				<p>Random numbers builder plugin allows the visitor to create random numbers on the page.</p>
				<div class="column-compatibility"><span class="compatibility-compatible"><strong>Compatible</strong> with your version of WordPress</span></div>
			</div>
		</div>
	</div>
    <div class="plugin-card">
        <div class="plugin-card-top">
            <a href="https://wordpress.org/plugins/expand-maker/" target="_blank" class="plugin-icon"><div class="plugin-icon" id="plugin-icon-readmore"></div></a>
            <div class="name column-name">
                <h4>
                    <a href="https://wordpress.org/plugins/expand-maker/" target="_blank">Read More</a>
                    <div class="action-links">
				 		<span class="plugin-action-buttons">
					 		<a class="install-now button" data-slug="expand-maker" href="<?php echo $expandMaker; ?>">Install Now</a>
					 	</span>
                    </div>
                </h4>
            </div>
            <div class="desc column-description">
                <p>The best wordpress "Read more" plugin to help you show or hide your long content.</p>
                <div class="column-compatibility"><span class="compatibility-compatible"><strong>Compatible</strong> with your version of WordPress</span></div>
            </div>
        </div>
    </div>
    <div class="plugin-card">
        <div class="plugin-card-top">
            <a href="https://wordpress.org/plugins/ydn-download/" target="_blank" class="plugin-icon"><div class="plugin-icon" id="plugin-icon-download"></div></a>
            <div class="name column-name">
                <h4>
                    <a href="https://wordpress.org/plugins/ydn-download/" target="_blank">Download,Digital Downloads,Download Manager,Download Monitor</a>
                    <div class="action-links">
				 		<span class="plugin-action-buttons">
					 		<a class="install-now button" data-slug="countdown-builder" href="<?php echo $downloaderURL; ?>">Install Now</a>
					 	</span>
                    </div>
                </h4>
            </div>
            <div class="desc column-description">
                <p>The easiest way to download files via wordpress Download plugin</p>
                <div class="column-compatibility"><span class="compatibility-compatible"><strong>Compatible</strong> with your version of WordPress</span></div>
            </div>
        </div>
    </div>
    <div class="plugin-card">
        <div class="plugin-card-top">
            <a href="https://wordpress.org/plugins/countdown-builder/" target="_blank" class="plugin-icon"><div class="plugin-icon" id="plugin-icon-scroll-top"></div></a>
            <div class="name column-name">
                <h4>
                    <a href="https://wordpress.org/plugins/scroll-to-top-builder/" target="_blank">Scroll to Top – WordPress Scroll to Top plugin.</a>
                    <div class="action-links">
				 		<span class="plugin-action-buttons">
					 		<a class="install-now button" data-slug="countdown-builder" href="<?php echo $scrollToTop; ?>">Install Now</a>
					 	</span>
                    </div>
                </h4>
            </div>
            <div class="desc column-description">
                <p>Scroll To Top Builder plugin allows the visitor to easily scroll back to the top of the page.</p>
                <div class="column-compatibility"><span class="compatibility-compatible"><strong>Compatible</strong> with your version of WordPress</span></div>
            </div>
        </div>
    </div>
	<div class="plugin-card">
		<div class="plugin-card-top">
			<a href="#" target="_blank" class="plugin-icon"><div class="plugin-icon" id="plugin-icon-contact-form"></div></a>
			<div class="name column-name">
				<h4>
					<a href="https://wordpress.org/plugins/contact-form-master/" target="_blank">Contact Form</a>
					<div class="action-links">
				 		<span class="plugin-action-buttons">
					 		<a class="install-now button" data-slug="contact-form-master" href="<?php echo $contactFormUrl; ?>">Install Now</a>
					 	</span>
					</div>
				</h4>
			</div>
			<div class="desc column-description">
				<p>Contact form is the most complete Contact form plugin. You can create different 'contact forms' with different fields.</p>
				<div class="column-compatibility"><span class="compatibility-compatible"><strong>Compatible</strong> with your version of WordPress</span></div>
			</div>
		</div>
	</div>
</div>
