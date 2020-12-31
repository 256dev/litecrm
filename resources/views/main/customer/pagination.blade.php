{{-- <div class="row justify-content-center"> 
    @if($pages > 1)
      <ul class="pagination">
      @if ($pages > 7)
          @if ($page < 5)
              <li class="page-item @if($page == 1) active @endif"><a href="{{ $url . '1' }}" class="page-link ">1</a></li>
              <li class="page-item @if($page == 2) active @endif"><a href="{{ $url . '2' }}" class="page-link ">2</a></li>
              <li class="page-item @if($page == 3) active @endif"><a href="{{ $url . '3' }}" class="page-link ">3</a></li>
              <li class="page-item @if($page == 4) active @endif"><a href="{{ $url . '4' }}" class="page-link ">4</a></li>
              <li class="page-item @if($page == 5) active @endif"><a href="{{ $url . '5' }}" class="page-link ">5</a></li>
              <li class="page-item disabled"><span class="page-link">...</span></li>
              <li class="page-item"><a href="{{ $url . $pages }}" class="page-link">{{ $pages }}</a></li>
          @elseif ($page > $pages - 5)
              <li class="page-item"><a href="{{ $url . '1' }}" class="page-link">1</a>
              <li class="page-item disabled"><span class="page-link">...</span></li>
              <li class="page-item @if($page == $pages - 4) active @endif"><a href="{{ $url . ($pages - 4) }}" class="page-link">{{ $pages - 4 }}</a>
              <li class="page-item @if($page == $pages - 3) active @endif"><a href="{{ $url . ($pages - 3) }}" class="page-link">{{ $pages - 3 }}</a>
              <li class="page-item @if($page == $pages - 2) active @endif"><a href="{{ $url . ($pages - 2) }}" class="page-link">{{ $pages - 2 }}</a>
              <li class="page-item @if($page == $pages - 1) active @endif"><a href="{{ $url . ($pages - 1) }}" class="page-link">{{ $pages - 1 }}</a>
              <li class="page-item @if($page == $pages) active @endif"><a href="{{ $url . $pages }}" class="page-link">{{ $pages }}</a>
          @else
              <li class="page-item"><a href="{{ $url . '1' }}" class="page-link">1</a></li>
              <li class="page-item disabled"><span class="page-link">...</span></li>
              <li class="page-item"><a href="{{ $url . ($page - 1) }}" class="page-link" >{{ $page - 1 }}</a></li>
              <li class="page-item active"><a href="{{ $url . $page }}" class="page-link" >{{ $page }}</a></li>
              <li class="page-item"><a href="{{ $url . ($page + 1) }}" class="page-link" >{{ $page + 1 }}</a></li>
              <li class="page-item disabled"><span class="page-link">...</span></li>
              <li class="page-item"><a href="{{ $url . $pages }}" class="page-link">{{ $pages }}</a></li>
          @endif
      @else
          @for ($num = 1; $num <= $pages; $num++)
              <li class="page-item @if($num == $page) active @endif"><a href="{{ $url . $num }}" class="page-link ">{{ $num }}</a></li>
          @endfor
      @endif
      </ul>
    @endif
  </div> --}}