<div
    is="{{ $tool->resolveNavigationComponent() }}"
    v-bind="{{ json_encode($tool->jsonSerialize()) }}">
</div>