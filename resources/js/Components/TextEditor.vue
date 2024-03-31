<script setup>
import { useForm } from '@inertiajs/vue3';
import PrimaryButton from './PrimaryButton.vue';
import { Trash2, Pencil, ShieldAlert, Bold, Italic, Strikethrough, Heading1, Heading2, List, ListOrdered } from 'lucide-vue-next';
import StarterKit from '@tiptap/starter-kit';
import Underline from '@tiptap/extension-underline';
import { useEditor, EditorContent } from '@tiptap/vue-3';

const props = defineProps({
    modelValue: {
        type: String,
        default: '',
    }
})

const emit = defineEmits(['update:modelValue']);

const editor = useEditor({
    editorProps: {
        attributes: {
        class: 'prose max-w-none border-[0.1rem] border-gray-300 focus:border-red-500 focus:ring-red-500 text-black rounded-[0.2rem] w-full resize-none h-[30rem] bg-white p-[1rem] overflow-y-auto outline-none',
    },
  },
  content: props.modelValue,
  extensions: [
    StarterKit,
    Underline,
  ],
  onUpdate: ({editor}) => {
        emit('update:modelValue', editor.getHTML())
    }
});

</script>

<template>
    <section
        v-if="editor"
        class="flex flex-wrap justify-center bg-gray-600 p-[0.6rem] my-[0.5rem] rounded-md items-center">
        <button @click="editor.chain().focus().toggleBold().run()" :disabled="!editor.can().chain().focus().toggleBold().run()" :class="{ 'bg-gray-900': editor.isActive('bold') }" class="m-1 p-2 bg-gray-500 rounded-sm ">
        <Bold/>
        </button>
        <button @click="editor.chain().focus().toggleItalic().run()" :disabled="!editor.can().chain().focus().toggleItalic().run()" :class="{ 'bg-gray-900': editor.isActive('italic') }" class="m-1 p-2 bg-gray-500 rounded-sm  italic">
        <Italic/>
        </button>
        <button @click="editor.chain().focus().toggleStrike().run()" :disabled="!editor.can().chain().focus().toggleStrike().run()" :class="{ 'bg-gray-900': editor.isActive('strike') }" class="m-1 p-2 bg-gray-500 rounded-sm ">
        <Strikethrough/>
        </button>
        <button @click="editor.chain().focus().toggleHeading({ level: 1 }).run()" :class="{ 'bg-gray-900': editor.isActive('heading', { level: 1 }) }" class="m-1 p-2 bg-gray-500 rounded-sm ">
        <Heading1/>
        </button>
        <button @click="editor.chain().focus().toggleHeading({ level: 2 }).run()" :class="{ 'bg-gray-900': editor.isActive('heading', { level: 2 }) }" class="m-1 p-2 bg-gray-500 rounded-sm ">
        <Heading2/>
        </button>
        <button @click="editor.chain().focus().toggleBulletList().run()" :class="{ 'bg-gray-900': editor.isActive('bulletList') }" class="m-1 p-2 bg-gray-500 rounded-sm ">
        <List/>
        </button>
        <button @click="editor.chain().focus().toggleOrderedList().run()" :class="{ 'bg-gray-900': editor.isActive('orderedList') }" class="m-1 p-2 bg-gray-500 rounded-sm ">
        <ListOrdered/>
        </button>
    </section>

    <EditorContent :editor="editor"/>
</template>
