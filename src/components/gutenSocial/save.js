/**
 * React hook that is used to mark the block wrapper element.
 * It provides all the necessary props like the class name.
 *
 * @see https://developer.wordpress.org/block-editor/packages/packages-block-editor/#useBlockProps
 */
 import { useBlockProps } from '@wordpress/block-editor';
 import { Dashicon } from '@wordpress/components';
 
 /**
  * The save function defines the way in which the different attributes should
  * be combined into the final markup, which is then serialized by the block
  * editor into `post_content`.
  *
  * @see https://developer.wordpress.org/block-editor/developers/block-api/block-edit-save/#save
  *
  * @param {Object} props            Properties passed to the function.
  * @param {Object} props.attributes Available block attributes.
  * @return {WPElement} Element to render.
  */
//  export default function socialLinkSave( props) {
const socialLinkSave = ( {
		attributes,
		context		
	} ) => {
	const {url, label} = attributes;
	const blockProps = useBlockProps.save();
		blockProps.className = blockProps.className + "  wp-block-social-link wp-social-link-xing";
		
	return (<li { ...blockProps }>
		 <a className="wp-social-link-anchor" href={url}
			target="_blank"
			rel="noopener nofollow" 
		>
			<Dashicon icon="xing" />
			{
			<span>
				{label}
			</span>}
		 </a>
	 </li>);
 }
 
 export default socialLinkSave;