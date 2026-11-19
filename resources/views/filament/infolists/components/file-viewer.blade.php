@if ($getState())
    <div class="flex items-center gap-2">
        <a 
            href="{{ asset('storage/' . $getState()) }}" 
            target="_blank" 
            class="text-blue-600 hover:underline">
            View File
        </a>
        <a 
            href="{{ asset('storage/' . $getState()) }}" 
            download 
            class="text-green-600 hover:underline">
            Download
        </a>
    </div>
@endif
