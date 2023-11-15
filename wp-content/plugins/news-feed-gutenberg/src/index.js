import { registerBlockType } from '@wordpress/blocks';
import ServerSideRender from '@wordpress/server-side-render';
import { useBlockProps } from '@wordpress/block-editor';

registerBlockType('news-feed-gutenberg/news-block', {
    title: 'News Block',
    icon: 'universal-access-alt',
    category: 'widgets',
    
    edit: (props) => {
        const blockProps = useBlockProps();
        return(
            <div { ...blockProps }>
                <ServerSideRender
                    block="news-feed-gutenberg/news-block"
                />
            </div>
        )
    },
});