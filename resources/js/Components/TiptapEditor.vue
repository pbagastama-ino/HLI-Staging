<template>
  <div class="tiptap-editor">
    <!-- Toolbar -->
    <div 
      v-if="editor" 
      class="flex flex-wrap items-center gap-1 p-2 border border-gray-300 border-b-0 rounded-t-lg bg-gray-50"
    >
      <button
        type="button"
        @click="editor.chain().focus().toggleBold().run()"
        :class="[
          'p-2 rounded hover:bg-gray-200 transition-colors',
          editor.isActive('bold') ? 'bg-gray-300' : ''
        ]"
        title="Bold"
      >
        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 4h8a4 4 0 014 4 4 4 0 01-4 4H6zM6 12h9a4 4 0 014 4 4 4 0 01-4 4H6z" />
        </svg>
      </button>
      
      <button
        type="button"
        @click="editor.chain().focus().toggleItalic().run()"
        :class="[
          'p-2 rounded hover:bg-gray-200 transition-colors',
          editor.isActive('italic') ? 'bg-gray-300' : ''
        ]"
        title="Italic"
      >
        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4" />
        </svg>
      </button>

      <div class="w-px h-6 bg-gray-300 mx-1"></div>

      <button
        type="button"
        @click="editor.chain().focus().toggleHeading({ level: 1 }).run()"
        :class="[
          'px-2 py-1 rounded hover:bg-gray-200 transition-colors text-sm font-bold',
          editor.isActive('heading', { level: 1 }) ? 'bg-gray-300' : ''
        ]"
        title="Heading 1"
      >
        H1
      </button>
      
      <button
        type="button"
        @click="editor.chain().focus().toggleHeading({ level: 2 }).run()"
        :class="[
          'px-2 py-1 rounded hover:bg-gray-200 transition-colors text-sm font-semibold',
          editor.isActive('heading', { level: 2 }) ? 'bg-gray-300' : ''
        ]"
        title="Heading 2"
      >
        H2
      </button>

      <button
        type="button"
        @click="editor.chain().focus().toggleHeading({ level: 3 }).run()"
        :class="[
          'px-2 py-1 rounded hover:bg-gray-200 transition-colors text-sm font-medium',
          editor.isActive('heading', { level: 3 }) ? 'bg-gray-300' : ''
        ]"
        title="Heading 3"
      >
        H3
      </button>

      <div class="w-px h-6 bg-gray-300 mx-1"></div>

      <button
        type="button"
        @click="editor.chain().focus().toggleBulletList().run()"
        :class="[
          'p-2 rounded hover:bg-gray-200 transition-colors',
          editor.isActive('bulletList') ? 'bg-gray-300' : ''
        ]"
        title="Bullet List"
      >
        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 6h13M8 12h13M8 18h13M3 6h.01M3 12h.01M3 18h.01" />
        </svg>
      </button>
      
      <button
        type="button"
        @click="editor.chain().focus().toggleOrderedList().run()"
        :class="[
          'p-2 rounded hover:bg-gray-200 transition-colors',
          editor.isActive('orderedList') ? 'bg-gray-300' : ''
        ]"
        title="Numbered List"
      >
        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 20l4-16m2 16l4-16M6 9h14M4 15h14" />
        </svg>
      </button>

      <div class="w-px h-6 bg-gray-300 mx-1"></div>

      <button
        type="button"
        @click="editor.chain().focus().toggleBlockquote().run()"
        :class="[
          'p-2 rounded hover:bg-gray-200 transition-colors',
          editor.isActive('blockquote') ? 'bg-gray-300' : ''
        ]"
        title="Quote"
      >
        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z" />
        </svg>
      </button>

      <div class="w-px h-6 bg-gray-300 mx-1"></div>

      <button
        type="button"
        @click="editor.chain().focus().undo().run()"
        :disabled="!editor.can().undo()"
        :class="[
          'p-2 rounded hover:bg-gray-200 transition-colors',
          !editor.can().undo() ? 'opacity-50 cursor-not-allowed' : ''
        ]"
        title="Undo"
      >
        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h10a8 8 0 018 8v2M3 10l6 6m-6-6l6-6" />
        </svg>
      </button>
      
      <button
        type="button"
        @click="editor.chain().focus().redo().run()"
        :disabled="!editor.can().redo()"
        :class="[
          'p-2 rounded hover:bg-gray-200 transition-colors',
          !editor.can().redo() ? 'opacity-50 cursor-not-allowed' : ''
        ]"
        title="Redo"
      >
        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 10h-10a8 8 0 00-8 8v2M21 10l-6 6m6-6l-6-6" />
        </svg>
      </button>
    </div>

    <!-- Editor Content -->
    <div 
      :class="[
        'border border-gray-300 rounded-lg focus-within:ring-2 focus-within:ring-[#4D9F95] focus-within:border-transparent transition-colors',
        hasError ? 'border-red-500' : '',
        !toolbar ? 'rounded-t-lg' : 'rounded-b-lg rounded-t-none'
      ]"
    >
      <EditorContent v-if="editor" :editor="editor" class="tiptap-content" />
      <div v-else class="p-4 min-h-[150px] text-gray-400">{{ placeholder }}</div>
    </div>
    
    <div v-if="errorMessage" class="mt-1 text-sm text-red-600">{{ errorMessage }}</div>
  </div>
</template>

<script setup>
import { watch, onBeforeUnmount } from 'vue'
import { useEditor, EditorContent } from '@tiptap/vue-3'
import StarterKit from '@tiptap/starter-kit'

const props = defineProps({
  modelValue: {
    type: String,
    default: ''
  },
  placeholder: {
    type: String,
    default: 'Start typing...'
  },
  hasError: {
    type: Boolean,
    default: false
  },
  errorMessage: {
    type: String,
    default: ''
  },
  toolbar: {
    type: Boolean,
    default: true
  },
  minHeight: {
    type: String,
    default: '200px'
  }
})

const emit = defineEmits(['update:modelValue'])

const editor = useEditor({
  content: props.modelValue || '',
  extensions: [StarterKit],
  editorProps: {
    attributes: {
      class: 'prose prose-sm max-w-none focus:outline-none p-4 tiptap-content-area',
      style: `min-height: ${props.minHeight}; font-family: system-ui, -apple-system, 'Segoe UI', 'Roboto', 'Helvetica Neue', Arial, sans-serif;`,
      'data-placeholder': props.placeholder
    }
  },
  onUpdate: ({ editor }) => {
    emit('update:modelValue', editor.getHTML())
  },
  onCreate: ({ editor }) => {
    if (props.modelValue) {
      editor.commands.setContent(props.modelValue)
    }
  }
})

// Watch for external changes to modelValue
watch(() => props.modelValue, (value) => {
  if (!editor.value) return
  const isSame = editor.value.getHTML() === value
  if (!isSame) {
    editor.value.commands.setContent(value || '')
  }
})

// Cleanup
onBeforeUnmount(() => {
  if (editor.value) {
    editor.value.destroy()
  }
})
</script>

<style scoped>
.tiptap-editor :deep(.tiptap-content) {
  outline: none;
}

/* Ensure toolbar uses system fonts */
.tiptap-editor {
  font-family: system-ui, -apple-system, 'Segoe UI', 'Roboto', 'Helvetica Neue', Arial, sans-serif !important;
  display: block;
}

.tiptap-editor :deep(.ProseMirror) {
  outline: none;
  min-height: v-bind(minHeight);
  padding: 1rem;
  font-family: system-ui, -apple-system, 'Segoe UI', 'Roboto', 'Helvetica Neue', Arial, sans-serif !important;
  font-weight: 400 !important;
}

/* Override global font-weight restrictions for all editor content */
.tiptap-editor :deep(.ProseMirror) * {
  font-family: system-ui, -apple-system, 'Segoe UI', 'Roboto', 'Helvetica Neue', Arial, sans-serif !important;
}

.tiptap-editor :deep(.ProseMirror p.is-editor-empty:first-child::before) {
  color: #9ca3af;
  content: attr(data-placeholder);
  float: left;
  height: 0;
  pointer-events: none;
}

.tiptap-editor :deep(.ProseMirror ul),
.tiptap-editor :deep(.ProseMirror ol) {
  padding-left: 1.5rem;
  margin: 0.75rem 0;
}

.tiptap-editor :deep(.ProseMirror ul) {
  list-style-type: disc;
}

.tiptap-editor :deep(.ProseMirror ol) {
  list-style-type: decimal;
}

.tiptap-editor :deep(.ProseMirror li) {
  margin: 0.25rem 0;
}

.tiptap-editor :deep(.ProseMirror h1) {
  font-size: 2em;
  font-weight: bold;
  margin: 1rem 0;
}

.tiptap-editor :deep(.ProseMirror h2) {
  font-size: 1.5em;
  font-weight: bold;
  margin: 0.875rem 0;
}

.tiptap-editor :deep(.ProseMirror h3) {
  font-size: 1.25em;
  font-weight: bold;
  margin: 0.75rem 0;
}

.tiptap-editor :deep(.ProseMirror blockquote) {
  border-left: 4px solid #4D9F95;
  padding-left: 1rem;
  margin: 1rem 0;
  font-style: italic;
  color: #6b7280;
}

.tiptap-editor :deep(.ProseMirror p) {
  margin: 0.5rem 0;
}

.tiptap-editor :deep(.ProseMirror p:first-child) {
  margin-top: 0;
}

.tiptap-editor :deep(.ProseMirror p:last-child) {
  margin-bottom: 0;
}

/* Set base font-weight for all editor content to override global styles */
.tiptap-editor :deep(.ProseMirror),
.tiptap-editor :deep(.ProseMirror *),
.tiptap-editor :deep(.ProseMirror p),
.tiptap-editor :deep(.ProseMirror div),
.tiptap-editor :deep(.ProseMirror span) {
  font-family: system-ui, -apple-system, 'Segoe UI', 'Roboto', 'Helvetica Neue', Arial, sans-serif !important;
}

/* Set default weight, but allow bold to override */
.tiptap-editor :deep(.ProseMirror p),
.tiptap-editor :deep(.ProseMirror div),
.tiptap-editor :deep(.ProseMirror span),
.tiptap-editor :deep(.ProseMirror li) {
  font-weight: 400 !important;
}

/* Bold text - CRITICAL: Must override all global restrictions with maximum specificity */
.tiptap-editor :deep(.ProseMirror strong),
.tiptap-editor :deep(.ProseMirror b),
.tiptap-editor :deep(.ProseMirror p strong),
.tiptap-editor :deep(.ProseMirror p b),
.tiptap-editor :deep(.ProseMirror div strong),
.tiptap-editor :deep(.ProseMirror div b),
.tiptap-editor :deep(.ProseMirror span strong),
.tiptap-editor :deep(.ProseMirror span b),
.tiptap-editor :deep(.ProseMirror li strong),
.tiptap-editor :deep(.ProseMirror li b),
.tiptap-editor :deep(.ProseMirror p strong *),
.tiptap-editor :deep(.ProseMirror p b *),
.tiptap-editor :deep(.ProseMirror strong *),
.tiptap-editor :deep(.ProseMirror b *) {
  font-weight: 700 !important;
  font-family: system-ui, -apple-system, 'Segoe UI', 'Roboto', 'Helvetica Neue', Arial, sans-serif !important;
}

/* Italic styling */
.tiptap-editor :deep(.ProseMirror em),
.tiptap-editor :deep(.ProseMirror i),
.tiptap-editor :deep(.ProseMirror p em),
.tiptap-editor :deep(.ProseMirror p i) {
  font-style: italic !important;
  font-family: system-ui, -apple-system, 'Segoe UI', 'Roboto', 'Helvetica Neue', Arial, sans-serif !important;
}
</style>

<style>
/* Global styles for Tiptap editor - not scoped to ensure they override everything */
.tiptap-content-area strong,
.tiptap-content-area b {
  font-weight: 700 !important;
  font-family: system-ui, -apple-system, 'Segoe UI', 'Roboto', 'Helvetica Neue', Arial, sans-serif !important;
}

.tiptap-content-area em,
.tiptap-content-area i {
  font-style: italic !important;
  font-family: system-ui, -apple-system, 'Segoe UI', 'Roboto', 'Helvetica Neue', Arial, sans-serif !important;
}

/* Override any global font-weight restrictions for editor content */
.tiptap-content-area p,
.tiptap-content-area div,
.tiptap-content-area span {
  font-family: system-ui, -apple-system, 'Segoe UI', 'Roboto', 'Helvetica Neue', Arial, sans-serif !important;
}

/* Ensure bold works even if parent has font-weight: 400 */
.tiptap-content-area p strong,
.tiptap-content-area p b,
.tiptap-content-area div strong,
.tiptap-content-area div b,
.tiptap-content-area span strong,
.tiptap-content-area span b,
.tiptap-content-area li strong,
.tiptap-content-area li b {
  font-weight: 700 !important;
}
</style>
