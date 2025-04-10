<div class="mb-4 border-b border-gray-700">
    <ul class="flex flex-wrap -mb-px text-sm font-medium text-center" id="default-tab" data-tabs-toggle="#default-tab-content" role="tablist">
        <li class="me-2" role="presentation">
            <button class="inline-block p-4 border-b-2 rounded-t-lg text-gray-400 hover:text-white hover:border-gray-300"
                id="profile-tab" data-tabs-target="#profile" type="button" role="tab" aria-controls="profile" aria-selected="true">
                <i data-lucide="user" class="inline w-4 h-4 me-1"></i> Profilo
            </button>
        </li>
        <li class="me-2" role="presentation">
            <button class="inline-block p-4 border-b-2 rounded-t-lg text-gray-400 hover:text-white hover:border-gray-300"
                id="settings-tab" data-tabs-target="#settings" type="button" role="tab" aria-controls="settings" aria-selected="false">
                <i data-lucide="settings" class="inline w-4 h-4 me-1"></i> Impostazioni
            </button>
        </li>
        <li role="presentation">
            <button class="inline-block p-4 border-b-2 rounded-t-lg text-gray-400 hover:text-white hover:border-gray-300"
                id="contacts-tab" data-tabs-target="#contacts" type="button" role="tab" aria-controls="contacts" aria-selected="false">
                <i data-lucide="mail" class="inline w-4 h-4 me-1"></i> Contatti
            </button>
        </li>
    </ul>
</div>

<div id="default-tab-content">
    <div class="hidden p-4 rounded-lg bg-gray-800 text-white" id="profile" role="tabpanel" aria-labelledby="profile-tab">
        <p class="text-sm text-gray-300">Contenuto della tab <strong>Profilo</strong>.</p>
    </div>
    <div class="hidden p-4 rounded-lg bg-gray-800 text-white" id="settings" role="tabpanel" aria-labelledby="settings-tab">
        <p class="text-sm text-gray-300">Contenuto della tab <strong>Impostazioni</strong>.</p>
    </div>
    <div class="hidden p-4 rounded-lg bg-gray-800 text-white" id="contacts" role="tabpanel" aria-labelledby="contacts-tab">
        <p class="text-sm text-gray-300">Contenuto della tab <strong>Contatti</strong>.</p>
    </div>
</div>
