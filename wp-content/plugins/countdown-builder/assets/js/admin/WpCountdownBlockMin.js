'use strict';

function WpCountdownBlock() {}

WpCountdownBlock.prototype.init = function () {
	if (typeof wp == 'undefined' || typeof wp.element == 'undefined' || typeof wp.blocks == 'undefined' || typeof wp.editor == 'undefined' || typeof wp.components == 'undefined') {
		return false;
	}
	var localizedParams = YCD_GUTENBERG_PARAMS;

	var __ = wp.i18n;
	var createElement = wp.element.createElement;
	var registerBlockType = wp.blocks.registerBlockType;
	var InspectorControls = wp.editor.InspectorControls;
	var _wp$components = wp.components,
	    SelectControl = _wp$components.SelectControl,
	    TextareaControl = _wp$components.TextareaControl,
	    ToggleControl = _wp$components.ToggleControl,
	    PanelBody = _wp$components.PanelBody,
	    ServerSideRender = _wp$components.ServerSideRender,
	    Placeholder = _wp$components.Placeholder;

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
		edit: function edit(props) {
			var _props$attributes = props.attributes,
			    _props$attributes$cou = _props$attributes.countdownId,
			    countdownId = _props$attributes$cou === undefined ? '' : _props$attributes$cou,
			    _props$attributes$dis = _props$attributes.displayTitle,
			    displayTitle = _props$attributes$dis === undefined ? false : _props$attributes$dis,
			    _props$attributes$dis2 = _props$attributes.displayDesc,
			    displayDesc = _props$attributes$dis2 === undefined ? false : _props$attributes$dis2,
			    setAttributes = props.setAttributes;

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
			var jsx = void 0;

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

			jsx = [React.createElement(
				InspectorControls,
				{ key: 'countdownbuilder-gutenberg-form-selector-inspector-controls' },
				React.createElement(
					PanelBody,
					{ title: 'countdown builder title' },
					React.createElement(SelectControl, {
						label: 'Select countdown',
						value: countdownId,
						options: countdownOptions,
						onChange: selectCountdown
					}),
					React.createElement(ToggleControl, {
						label: 'Select countdown',
						checked: displayTitle,
						onChange: toggleDisplayTitle
					}),
					React.createElement(ToggleControl, {
						label: '',
						checked: displayDesc,
						onChange: toggleDisplayDesc
					})
				)
			)];

			if (countdownId) {
				return '[ycd_countdown id="' + countdownId + '"][/ycd_countdown]';
			} else {
				jsx.push(React.createElement(
					Placeholder,
					{
						key: 'ycd-gutenberg-form-selector-wrap',
						className: 'ycd-gutenberg-form-selector-wrapper' },
					React.createElement(SelectControl, {
						key: 'ycd-gutenberg-form-selector-select-control',
						value: countdownId,
						options: countdownOptions,
						onChange: selectCountdown
					}),
					React.createElement(SelectControl, {
						key: 'ycd-gutenberg-form-selector-select-control',
						onChange: selectCountdown
					})
				));
			}

			return jsx;
		},
		save: function save(props) {

			return '[ycd_countdown id="' + props.attributes.countdownId + '"][/ycd_countdown]';
		}
	});
};

jQuery(document).ready(function () {
	var block = new WpCountdownBlock();
	block.init();
});