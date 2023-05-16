<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
</script>

<template>
  <div class="p-6">
    <div class="flex justify-between">
      <input 
        type="text" 
        v-model="search" 
        placeholder="Search games..." 
        class="w-full p-2 mb-6 border rounded"
      />

      <button @click="openNewGameModal" class="ml-4 p-2 bg-blue-500 text-white rounded">Add game</button>
    </div>

    <ul role="list" class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-3">
      <li v-for="game in filteredGames" 
            :key="game.id" 
            @click="openEditGameModal(game)"
            class="col-span-1 divide-y divide-gray-200 rounded-lg bg-white shadow">
        <div class="flex w-full items-center justify-between space-x-6 p-6">
          <div class="flex-1 truncate">
            <div class="flex items-center space-x-3">
              <h3 class="truncate text-sm font-medium text-gray-900">{{ game.title }}</h3>
              <span class="inline-flex flex-shrink-0 items-center rounded-full bg-green-50 px-1.5 py-0.5 text-xs font-medium text-green-700 ring-1 ring-inset ring-green-600/20">Rating {{ game.rating }}</span>
            </div>
            <p class="mt-1 truncate text-sm text-gray-500">By: {{ game.publisher }}</p>
            <p class="mt-1 truncate text-sm text-gray-500">{{ game.min_players }} to {{ game.max_players }} players</p>
          </div>
          <button @click.stop="vote(game.id, 1)" class="sm p-2"><svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-thumbs-up"><path d="M14 9V5a3 3 0 0 0-3-3l-4 9v11h11.28a2 2 0 0 0 2-1.7l1.38-9a2 2 0 0 0-2-2.3zM7 22H4a2 2 0 0 1-2-2v-7a2 2 0 0 1 2-2h3"></path></svg></button>
        <button @click.stop="vote(game.id, 0)" class="sm p-2"><svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-thumbs-down"><path d="M10 15v4a3 3 0 0 0 3 3l4-9V2H5.72a2 2 0 0 0-2 1.7l-1.38 9a2 2 0 0 0 2 2.3zm7-13h2.67A2.31 2.31 0 0 1 22 4v7a2.31 2.31 0 0 1-2.33 2H17"></path></svg></button>
        </div>
        
      </li>
    </ul>

    <div v-if="selectedGame" class="fixed inset-0 flex items-center justify-center p-6 bg-black bg-opacity-50">
      <div class="w-1/2 p-6 bg-white rounded">
        <h2 class="mb-4 text-center text-lg font-bold">Edit Game</h2>

        <label class="block mb-2">Title</label>
        <input type="text" v-model="selectedGame.title" class="w-full p-2 mb-4 border rounded" />

        <label class="block mb-2">Publisher</label>
        <input type="text" v-model="selectedGame.publisher" class="w-full p-2 mb-4 border rounded" />

        <label class="block mb-2">Minimum Players</label>
        <input type="text" v-model="selectedGame.min_players" class="w-full p-2 mb-4 border rounded" />

        <label class="block mb-2">Maximum Players</label>
        <input type="text" v-model="selectedGame.max_players" class="w-full p-2 mb-4 border rounded" />

        <div class="flex justify-end">
          <button @click="saveGame" class="p-2 mr-2 text-white bg-blue-500 rounded">Save</button>
          <button @click="closeModal" class="p-2 text-white bg-red-500 rounded">Cancel</button>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  data() {
    return {
      search: "",
      games: [],
      selectedGame: null
    };
  },
  async mounted() {
    const response = await fetch('/api/games');
    this.games = await response.json();
  },
  computed: {
    filteredGames() {
      if (!this.search) return this.games;

      return this.games.filter(game => game.title.toLowerCase().includes(this.search.toLowerCase()));
    }
  },
  methods: {
    openNewGameModal() {
      this.selectedGame = { id: this.nextId, title: "", publisher: "", min_players: "", max_players: "" };
      this.modalOpen = true;
    },
    openEditGameModal(game) {
      this.selectedGame = { ...game };
      this.modalOpen = true;
    },
    async saveGame() {
      try {
        await fetch('/api/games', {
          method: 'POST',
          headers: {
            'Content-Type': 'application/json'
          },
          body: JSON.stringify(this.selectedGame)
        });
        
        const response = await fetch('/api/games');
        this.games = await response.json();
      } catch (err) {
        console.error(err);
        // Add error handling here
      } finally {
        this.selectedGame = null;
      }
    },
    closeModal() {
      this.selectedGame = null;
    },
    async vote(gameId, direction) {
      try {
        await fetch(`/api/games/${gameId}/vote`, {
          method: 'POST',
          headers: {
            'Content-Type': 'application/json'
          },
          body: JSON.stringify({ vote:direction })
        });

        const response = await fetch('/api/games');
        this.games = await response.json();
      } catch (err) {
        console.error(err);
        // Add error handling here
      }
    },
    
  }
};
</script>

<style>
/* Add your Tailwind CSS styles here */
</style>
