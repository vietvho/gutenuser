/**
 * External dependencies
 */
 import classNames from 'classnames';

 /**
  * WordPress dependencies
  */
 import {
	 InspectorControls,
	 URLPopover,
	 URLInput,
	 useBlockProps,
 } from '@wordpress/block-editor';
 import { Fragment, useState, useRef } from '@wordpress/element';
 import {
	 Button,
	 PanelBody,
	 PanelRow,
	 TextControl,
 } from '@wordpress/components';
 import { __, sprintf } from '@wordpress/i18n';
 import { keyboardReturn } from '@wordpress/icons';
 import { Dashicon } from '@wordpress/components';

 /**
  * Internal dependencies
  */
 
 const SocialLinkURLPopover = ( {
	 url,
	 setAttributes,
	 setPopover,
	 anchorRef,
 } ) => (
	 <URLPopover
		 anchorRef={ anchorRef?.current }
		 onClose={ () => setPopover( false ) }
	 >
		 <form
			 className="block-editor-url-popover__link-editor"
			 onSubmit={ ( event ) => {
				 event.preventDefault();
				 setPopover( false );
			 } }
		 >
			 <div className="block-editor-url-input">
				 <URLInput
					 value={ url }
					 onChange={ ( nextURL ) =>
						 setAttributes( { url: nextURL } )
					 }
					 placeholder={ __( 'Enter address' ) }
					 disableSuggestions={ true }
				 />
			 </div>
			 <Button
				 icon={ keyboardReturn }
				 label={ __( 'Apply' ) }
				 type="submit"
			 />
		 </form>
	 </URLPopover>
 );

 const SocialLinkEdit = ( {
	 attributes,
	 context,
	 isSelected,
	 setAttributes,
 } ) => {
	 const { url, label } = attributes;
	 const { showLabels, iconColorValue, iconBackgroundColorValue } = context;
	 const [ showURLPopover, setPopover ] = useState( false );
	 const classes = classNames( 'wp-social-link', 'wp-block-social-link', 'wp-social-link-xing', {
		 'wp-social-link__is-incomplete': ! url,
	 } );
 
	 const ref = useRef();
	 const socialLinkName = 'Xing';
	 const socialLinkLabel = label ?? socialLinkName;
	 const blockProps = useBlockProps( {
		 className: classes,
		 style: {
			 color: iconColorValue,
			 backgroundColor: iconBackgroundColorValue,
		 },
	 } );
 
	 return (
		 <Fragment>
			 <InspectorControls>
				 <PanelBody
					 title={ sprintf(
						 /* translators: %s: name of the social service. */
						 __( '%s label' ),
						 socialLinkName
					 ) }
					 initialOpen={ false }
				 >
					 <PanelRow>
						 <TextControl
							 label={ __( 'Link label' ) }
							 help={ __(
								 'Briefly describe the link to help screen reader users.'
							 ) }
							 value={ label }
							 onChange={ ( value ) =>
								 setAttributes( { label: value } )
							 }
						 />
					 </PanelRow>
				 </PanelBody>
			 </InspectorControls>
			 <li { ...blockProps }>
				 <Button
					 className="wp-block-social-link-anchor"
					 ref={ ref }
					 onClick={ () => setPopover( true ) }
				 >
					 <Dashicon icon="xing" />
					 <span
						 className={ classNames( 'wp-block-social-link-label', {
							 'screen-reader-text': ! showLabels,
						 } ) }
					 >
						 { socialLinkLabel }
					 </span>
					 { isSelected && showURLPopover && (
						 <SocialLinkURLPopover
							 url={ url }
							 setAttributes={ setAttributes }
							 setPopover={ setPopover }
							 anchorRef={ ref }
						 />
					 ) }
				 </Button>
			 </li>
		 </Fragment>
	 );
 };
 
 export default SocialLinkEdit;
 