@foreach($categories as $subCategory)
    <li class="{{ $categoryPath->contains('id', $subCategory->id) ? 'active' : '' }}">
        <a href="{{ route('categories.show', $subCategory->id) }}">
            <span class="categories_name">{{ $subCategory->name }}</span>
            @if($subCategory->children->count() > 0)
                <span class="toggle-icon {{ $categoryPath->contains('id', $subCategory->id) ? 'open' : '' }}">
                    <i class="fa-solid fa-chevron-down"></i>
                </span>
            @endif
        </a>
        @if($subCategory->children->count() > 0)
            <ul class="sub-categories {{ $categoryPath->contains('id', $subCategory->id) ? 'show' : '' }}">
                @include('categories.partials.subcategories', ['categories' => $subCategory->children, 'categoryPath' => $categoryPath])
            </ul>
        @endif
    </li>
@endforeach 