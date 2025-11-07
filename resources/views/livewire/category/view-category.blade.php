<div>
    @if ($category)
        <div class="card shadow-sm mb-4">
            <div class="card-body">
                <div class="d-flex align-items-center mb-3">
                    @if ($category['image_url'])
                        <img src="{{ $category['image_url'] }}" alt="{{ $category['name'] }}" class="rounded-circle me-3"
                            width="80" height="80">
                    @else
                        <img src="{{ asset('images/default.png') }}" alt="{{ $category['name'] }}" class="rounded-circle me-3"
                            width="80" height="80">
                    @endif

                    <div>
                        <h4 class="mb-1">{{ $category['name'] }}</h4>
                        <p class="text-muted mb-0">
                            {{ $category['description'] ?? 'No description available.' }}
                        </p>
                    </div>
                </div>

                <hr>

                <h5 class="mb-3 d-flex justify-content-between align-items-center">
                    Specifications
                    <button class="btn btn-sm btn-success" wire:click="addSpecification">
                        <i class="bi bi-plus-circle"></i> Add Specification
                    </button>
                </h5>

                @if (!empty($category['specification_keys']))
                    <div class="accordion" id="specAccordion">
                        @foreach ($category['specification_keys'] as $index => $spec)
                            <div class="accordion-item mb-2">
                                <h2 class="accordion-header" id="heading{{ $index }}">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                        data-bs-target="#collapse{{ $index }}" aria-expanded="false"
                                        aria-controls="collapse{{ $index }}">
                                        {{ $spec['name'] }}
                                        <span class="badge bg-secondary ms-2">{{ ucfirst($spec['type']) }}</span>
                                    </button>
                                </h2>

                                <div id="collapse{{ $index }}" class="accordion-collapse collapse"
                                    aria-labelledby="heading{{ $index }}" data-bs-parent="#specAccordion">
                                    <div class="accordion-body">
                                        <div class="d-flex justify-content-end mb-2">
                                            <button class="btn btn-sm btn-primary me-2"
                                                wire:click="editSpecification('{{ $spec['id'] }}')">
                                                <i class="bi bi-pencil-square"></i> Edit
                                            </button>
                                            <button class="btn btn-sm btn-danger"
                                                wire:click="deleteSpecification('{{ $spec['id'] }}')"
                                                wire:confirm="Are you sure you want to delete this specification?">
                                                <i class="bi bi-trash"></i> Delete
                                            </button>
                                        </div>

                                        @if (!empty($spec['specification_values']))
                                            <ul class="list-group list-group-flush">
                                                @foreach ($spec['specification_values'] as $value)
                                                    <li class="list-group-item">
                                                        {{ $value['value'] }}
                                                        @if ($value['extra_info'])
                                                            <small class="text-muted d-block">{{ $value['extra_info'] }}</small>
                                                        @endif
                                                    </li>
                                                @endforeach
                                            </ul>
                                        @else
                                            <p class="text-muted mb-0">No values found for this specification.</p>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <p class="text-muted">No specifications found for this category.</p>
                @endif
            </div>
        </div>
    @else
        <div class="alert alert-warning">No category data available.</div>
    @endif
</div>
