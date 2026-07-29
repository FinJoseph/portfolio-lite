import { ref, onMounted } from 'vue';
import Fuse from 'fuse.js';

export function useSearch() {
    const searchIndex = ref([]);
    const fuse = ref(null);
    const loaded = ref(false);

    onMounted(async () => {
        try {
            const res = await fetch('/search-index.json');
            const data = await res.json();
            searchIndex.value = data;
            fuse.value = new Fuse(data, {
                keys: ['title', 'excerpt', 'type'],
                threshold: 0.4,
                minMatchCharLength: 2,
            });
            loaded.value = true;
        } catch {
            loaded.value = false;
        }
    });

    function search(query) {
        if (!query || !fuse.value) return [];
        return fuse.value.search(query).map(r => r.item);
    }

    return { search, searchIndex, loaded };
}
