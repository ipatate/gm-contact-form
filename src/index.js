import { registerBlockType } from '@wordpress/blocks'
import ServerSideRender from '@wordpress/server-side-render'
import { __ } from '@wordpress/i18n'
import { useBlockProps } from '@wordpress/block-editor'

registerBlockType('goodmotion/block-gm-contact-form', {
  title: __('GM Contact Form', 'gm-contact-form'),
  description: __('Block for display contact form contact', 'gm-contact-form'),
  icon: 'email',
  category: 'theme',
  example: {},
  attributes: {},
  edit: (props) => {
    const blockProps = useBlockProps()
    return (
      <div {...blockProps}>
        <ServerSideRender block="goodmotion/block-gm-contact-form" />
      </div>
    )
  },
  // save
})
