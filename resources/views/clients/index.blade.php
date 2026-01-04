<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-2xl text-white leading-tight">
                {{ __('Clients') }}
            </h2>
            <a href="{{ route('clients.create') }}"
                class="px-5 py-2.5 bg-indigo-600 hover:bg-indigo-500 text-white font-medium rounded-lg shadow-lg shadow-indigo-500/30 ring-1 ring-indigo-500/50 transition-all duration-200 backdrop-blur-sm">
                + Add Client
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="glass overflow-hidden rounded-xl">
                <div class="p-6 text-slate-100">

                    @if(session('success'))
                        <div class="bg-emerald-500/10 border-l-4 border-emerald-500 text-emerald-400 p-4 mb-6 rounded-r-lg"
                            role="alert">
                            <p class="font-bold">Success</p>
                            <p>{{ session('success') }}</p>
                        </div>
                    @endif

                    <div class="overflow-x-auto rounded-lg">
                        <table class="min-w-full divide-y divide-white/10">
                            <thead class="bg-white/5">
                                <tr>
                                    <th scope="col"
                                        class="px-6 py-3 text-left text-xs font-medium text-slate-400 uppercase tracking-wider">
                                        Name</th>
                                    <th scope="col"
                                        class="px-6 py-3 text-left text-xs font-medium text-slate-400 uppercase tracking-wider">
                                        Email</th>
                                    <th scope="col"
                                        class="px-6 py-3 text-left text-xs font-medium text-slate-400 uppercase tracking-wider">
                                        Phone</th>
                                    <th scope="col"
                                        class="px-6 py-3 text-left text-xs font-medium text-slate-400 uppercase tracking-wider">
                                        Actions</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-white/5">
                                @foreach($clients as $client)
                                    <tr class="hover:bg-white/5 transition duration-150">
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <a href="{{ route('clients.show', $client) }}" class="group block">
                                                <div
                                                    class="text-sm font-bold text-indigo-400 group-hover:text-indigo-300 transition-colors">
                                                    {{ $client->company_name ?? $client->name }}
                                                </div>
                                                @if($client->company_name)
                                                    <div class="text-xs text-slate-500 mt-0.5">
                                                        {{ $client->name }}
                                                    </div>
                                                @endif
                                                <div class="text-xs text-slate-600 mt-1 truncate max-w-xs">
                                                    {{ $client->address }}</div>
                                            </a>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm text-slate-300">{{ $client->email }}</div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm text-slate-300">{{ $client->phone }}</div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                            <a href="{{ route('clients.edit', $client) }}"
                                                class="text-indigo-400 hover:text-indigo-300 mr-4 transition">Edit</a>
                                            <form action="{{ route('clients.destroy', $client) }}" method="POST"
                                                class="inline-block"
                                                onsubmit="return confirm('Are you sure you want to delete this client?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                    class="text-rose-400 hover:text-rose-300 transition">Delete</button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="mt-4">
                        {{ $clients->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>