<div class="mb-8">

    <router-link tag="h3" :to="{
        name: 'nav-group-dashboard',
        params: {
            codeName: '{{ $tool->getCodeName() }}'
        }
    }" class="cursor-pointer flex items-center font-normal dim text-white mb-4 text-base no-underline">
        <span class="sidebar-icon">
        {!! $tool->getIcon() !!}
        </span>

        <span class="sidebar-label">
        {{ $tool->label }}
    </span>
    </router-link>


    <ul class="list-reset mb-4">
        @foreach($tool->resources as $resource)
            <li class="leading-tight mb-2 ml-3 text-sm">
                <router-link :to="{
                name: 'index',
                params: {
                    resourceName: '{{ $resource::uriKey() }}'
                }
            }" class="cursor-pointer flex items-center font-normal dim text-white mb-3 text-base no-underline">
                <span class="resource-icon">
                    {!! $resource::getIcon() !!}
                </span>

                <span class="resource-label">
                    {{ $resource::label() }}
                </span>
                </router-link>
            </li>
        @endforeach
    </ul>

</div>
