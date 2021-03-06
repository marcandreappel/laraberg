import { configureAPI } from '../api/api-fetch'
import configureEditor from '../lib/configure-editor'
import { elementReady } from '../lib/element-ready'
import { editorSettings, overridePost } from './settings'

const { blocks, data, domReady, editPost, plugins } = window.wp
const { unregisterBlockType, registerBlockType, getBlockType } = blocks

/**
 * Initialize the Gutenberg editor
 * @param {string} target the element ID to render the gutenberg editor in
 */
export default function init(target, options = {})
{
    configureAPI(options)

    // Toggle features
    const { toggleFeature } = data.dispatch('core/edit-post')
    toggleFeature('welcomeGuide')
    toggleFeature('fullscreenMode')

    // Disable block patterns
    plugins.unregisterPlugin('edit-post')

    window._wpLoadGutenbergEditor = new Promise(function (resolve)
    {
        domReady(async () =>
        {
            const larabergEditor = createEditorElement(target)
            try {
                resolve(editPost.initializeEditor(larabergEditor.id, 'page', 1, getEditorSettings(), overridePost))
                fixReusableBlocks()
            } catch (error) {
                console.error(error)
            }
            await elementReady('.edit-post-layout')
            configureEditor(options)
        })
    })
}

/**
 * Creates the element to render the Gutenberg editor inside of
 * @param {string} target the id of the textarea to render the Editor instead of
 * @return {element}
 */
function createEditorElement(target)
{
    const element = document.getElementById(target)
    const editor = document.createElement('DIV')
    editor.id = 'laraberg__editor'
    editor.classList.add('laraberg__editor', 'gutenberg__editor', 'block-editor__container', 'wp-embed-responsive')
    element.parentNode.insertBefore(editor, element)
    element.hidden = true

    editorSettings.target = target
    window.Laraberg.editor = editor

    return editor
}

function fixReusableBlocks()
{
    const coreBlock = getBlockType('core/block')
    unregisterBlockType('core/block')
    coreBlock.attributes = {
        ref: {
            type: 'number'
        }
    }
    registerBlockType('core/block', coreBlock)
}

function getEditorSettings()
{
    const targetElement = document.getElementById(editorSettings.target)

    if (targetElement && targetElement.placeholder) {
        editorSettings.bodyPlaceholder = targetElement.placeholder
    }

    return editorSettings
}
