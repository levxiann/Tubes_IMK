@if (isset($paginator) && $paginator->lastPage() > 1)

    <nav aria-label="Page_navigation example">
    <ul class="pagination justify-content-center">

        <?php
        $interval = isset($interval) ? abs(intval($interval)) : 3 ;
        $from = $paginator->currentPage() - $interval;
        if($from < 1){
            $from = 1;
        }

        $to = $paginator->currentPage() + $interval;
        if($to > $paginator->lastPage()){
            $to = $paginator->lastPage();
        }
        ?>

        <!-- first/previous -->
        @if($paginator->currentPage() > 1)
            <li class="page-item">
                <a class="page-link" href="{{ $paginator->url(1) }}" aria-label="First">
                    <span aria-hidden="true">&laquo;</span>
                </a>
            </li>

            <li class="page-item">
                <a class="page-link" href="{{ $paginator->url($paginator->currentPage() - 1) }}" aria-label="Previous">
                    <span aria-hidden="true">&lsaquo;</span>
                </a>
            </li>
        @endif

        <!-- links -->
        @for($i = $from; $i <= $to; $i++)
            <?php 
            $isCurrentPage = $paginator->currentPage() == $i;
            ?>
            
        @endfor
        <li class="page-item active">
            <a class="page-link" href="#">
                {{ $paginator->currentPage() }}
            </a>
        </li>

        <!-- next/last -->
        @if($paginator->currentPage() < $paginator->lastPage())
            <li class="page-item">
                <a class="page-link" href="{{ $paginator->url($paginator->currentPage() + 1) }}" aria-label="Next">
                    <span aria-hidden="true">&rsaquo;</span>
                </a>
            </li>

            <li class="page-item">
                <a class="page-link" href="{{ $paginator->url($paginator->lastpage()) }}" aria-label="Last">
                    <span aria-hidden="true">&raquo;</span>
                </a>
            </li>
        @endif

    </ul>
    </nav>
    </br>
@endif