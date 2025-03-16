import {
    ClassicEditor,
    Autoformat,
    AutoLink,
    Autosave,
    Bold,
    Code,
    CodeBlock,
    Essentials,
    FindAndReplace,
    FullPage,
    GeneralHtmlSupport,
    Heading,
    Highlight,
    HtmlComment,
    HtmlEmbed,
    Italic,
    Link,
    List,
    ListProperties,
    PageBreak,
    Paragraph,
    RemoveFormat,
    ShowBlocks,
    SourceEditing,
    SpecialCharacters,
    SpecialCharactersArrows,
    SpecialCharactersCurrency,
    SpecialCharactersEssentials,
    SpecialCharactersLatin,
    SpecialCharactersMathematical,
    SpecialCharactersText,
    Strikethrough,
    Subscript,
    Superscript,
    Table,
    TableCaption,
    TableCellProperties,
    TableColumnResize,
    TableProperties,
    TableToolbar,
    TextTransformation,
    TodoList,
    Underline
} from 'ckeditor5';

import translations from '/assets/plugins/ckeditor/translations/pl.js';

const editorConfig = {
    toolbar: {
        items: [
            'sourceEditing',
            'showBlocks',
            '|',
            'heading',
            '|',
            'bold',
            'italic',
            'underline',
            '|',
            'link',
            'insertTable',
            'highlight',
            'codeBlock',
            '|',
            'bulletedList',
            'numberedList',
            'todoList'
        ],
        shouldNotGroupWhenFull: false
    },
    plugins: [
        Autoformat,
        AutoLink,
        Autosave,
        Bold,
        Code,
        CodeBlock,
        Essentials,
        FindAndReplace,
        FullPage,
        GeneralHtmlSupport,
        Heading,
        Highlight,
        HtmlComment,
        HtmlEmbed,
        Italic,
        Link,
        List,
        ListProperties,
        PageBreak,
        Paragraph,
        RemoveFormat,
        ShowBlocks,
        SourceEditing,
        SpecialCharacters,
        SpecialCharactersArrows,
        SpecialCharactersCurrency,
        SpecialCharactersEssentials,
        SpecialCharactersLatin,
        SpecialCharactersMathematical,
        SpecialCharactersText,
        Strikethrough,
        Subscript,
        Superscript,
        Table,
        TableCaption,
        TableCellProperties,
        TableColumnResize,
        TableProperties,
        TableToolbar,
        TextTransformation,
        TodoList,
        Underline
    ],
    heading: {
        options: [
            {
                model: 'paragraph',
                title: 'Paragraph',
                class: 'ck-heading_paragraph'
            },
            {
                model: 'heading1',
                view: 'h1',
                title: 'Heading 1',
                class: 'ck-heading_heading1'
            },
            {
                model: 'heading2',
                view: 'h2',
                title: 'Heading 2',
                class: 'ck-heading_heading2'
            },
            {
                model: 'heading3',
                view: 'h3',
                title: 'Heading 3',
                class: 'ck-heading_heading3'
            },
            {
                model: 'heading4',
                view: 'h4',
                title: 'Heading 4',
                class: 'ck-heading_heading4'
            },
            {
                model: 'heading5',
                view: 'h5',
                title: 'Heading 5',
                class: 'ck-heading_heading5'
            },
            {
                model: 'heading6',
                view: 'h6',
                title: 'Heading 6',
                class: 'ck-heading_heading6'
            }
        ]
    },
    htmlSupport: {
        allow: [
            {
                name: /^.*$/,
                styles: true,
                attributes: true,
                classes: true
            }
        ]
    },
    initialData: '',
    language: 'pl',
    licenseKey: 'GPL',
    link: {
        addTargetToExternalLinks: true,
        defaultProtocol: 'https://',
        decorators: {
            toggleDownloadable: {
                mode: 'manual',
                label: 'Downloadable',
                attributes: {
                    download: 'file'
                }
            }
        }
    },
    list: {
        properties: {
            styles: true,
            startIndex: true,
            reversed: true
        }
    },
    menuBar: {
        isVisible: true
    },
    placeholder: '',
    table: {
        contentToolbar: ['tableColumn', 'tableRow', 'mergeTableCells', 'tableProperties', 'tableCellProperties']
    },
    translations: [translations]
};

ClassicEditor.create(document.querySelector('#editor'), editorConfig).then(editor => {
    window.editor = editor;
})
.catch(error => {
    console.error(error);
});