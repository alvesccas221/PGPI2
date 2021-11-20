function WpCountdownBlock() {

}

WpCountdownBlock.prototype.init = function() {
	if (typeof wp == 'undefined' || typeof wp.element == 'undefined' || typeof wp.blocks == 'undefined' || typeof wp.editor == 'undefined' || typeof wp.components == 'undefined') {
		return false;
	}
	var localizedParams = YCD_GUTENBERG_PARAMS;

	var __ = wp.i18n;
	var createElement     = wp.element.createElement;
	var registerBlockType = wp.blocks.registerBlockType;
	var InspectorControls = wp.editor.InspectorControls;
	var _wp$components    = wp.components,
		SelectControl     = _wp$components.SelectControl,
		TextareaControl   = _wp$components.TextareaControl,
		ToggleControl     = _wp$components.ToggleControl,
		PanelBody         = _wp$components.PanelBody,
		ServerSideRender  = _wp$components.ServerSideRender,
		Placeholder       = _wp$components.Placeholder;

	registerBlockType('countdownbuilder/countdowns', {
		title: localizedParams.title,
		description: localizedParams.description,
		keywords: ['countdown', 'countdowns', 'countdown builder'],
		category: 'widgets',
		icon: 'welcome-widgets-menus',
		attributes: {
			countdownId: {
				type: 'number'
			}
		},
		edit(props) {
			const {
				attributes: {
					countdownId = '',
					displayTitle = false,
					displayDesc = false
				},
				setAttributes
			} = props;
			
			const countdownOptions = [];
			let allCountdowns = YCD_GUTENBERG_PARAMS.allCountdowns;
			for(var id in allCountdowns) {
				 var currentdownObj = {
				 	value: id,
				 	label: allCountdowns[id]
				 }
				 countdownOptions.push(currentdownObj);
			}
			countdownOptions.unshift({
                value: '',
                label: YCD_GUTENBERG_PARAMS.coountdown_select
            })
			let jsx;

			function selectCountdown(value) {
				setAttributes({
					countdownId: value
				});
			}

			function setContent(value) {
				setAttributes({
					content: value
				});
			}

			function toggleDisplayTitle(value) {
				setAttributes({
					displayTitle: value
				});
			}

			function toggleDisplayDesc(value) {
				setAttributes({
					displayDesc: value
				});
			}

			jsx = [
				<InspectorControls key="countdownbuilder-gutenberg-form-selector-inspector-controls">
					<PanelBody title={'countdown builder title'}>
						<SelectControl
							label = {''}
							value = {countdownId}
							options = {countdownOptions}
							onChange = {selectCountdown}
						/>
						<ToggleControl
							label = {YCD_GUTENBERG_PARAMS.i18n.show_title}
							checked = {displayTitle}
							onChange = {toggleDisplayTitle}
						/>
						<ToggleControl
							label = {YCD_GUTENBERG_PARAMS.i18n.show_description}
							checked = {displayDesc}
							onChange = {toggleDisplayDesc}
						/>
					</PanelBody>
				</InspectorControls>
			];

			if (countdownId) {
				return '[ycd_countdown id="'+countdownId+'"][/ycd_countdown]';
			}
			else {
				jsx.push(
					<Placeholder
					key="ycd-gutenberg-form-selector-wrap"
					className="ycd-gutenberg-form-selector-wrapper">
						<SelectControl
							key = "ycd-gutenberg-form-selector-select-control"
							value = {countdownId}
							options = {countdownOptions}
							onChange = {selectCountdown}
						/>
						<SelectControl
							key = "ycd-gutenberg-form-selector-select-control"
							onChange = {selectCountdown}
						/>
					</Placeholder>
				);
			}

			return jsx;
		},
		save(props) {

			return '[ycd_countdown id="'+props.attributes.countdownId+'"][/ycd_countdown]';
		}
	});
};

jQuery(document).ready(function () {
	var block = new WpCountdownBlock();
	block.init();
});