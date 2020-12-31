<div class="container py-2">
    <div class="row justify-content-center">
        <table class="table table-striped shadow table-responsive-sm">
            <thead class="thead-dark">
                <tr>
                    <th scope="col" class="align-middle text-center py-1">
                        Название
                    </th>
                    <th scope="col" class="align-middle text-center py-1">
                        Комментарий
                    </th>
                    <th scope="col" class="align-middle text-center py-1">
                        Основная
                    </th>
                    <th scope="col" class="align-middle text-center py-1">
                        Приоритет
                    </th>
                </tr>
            </thead>
            <tbody>
                @foreach ($items as $item)
                    <tr onclick="window.location.href='{{ route($route, $item->id)}}';">
                        <td scope="row" class="align-middle text-center">
                            {{ $item->name }}
                        </td>
                        <td scope="row" class="align-middle text-center">
                            {{ $item->comment }}
                        </td>
                        <td scope="row" class="align-middle text-center">
                            @if ($item->main)
                                <i class="fas fa-check" aria-hidden="true"></i>
                            @else
                                <i class="fas fa-times" aria-hidden="true"></i>
                            @endif
                        </td>
                        <td scope="row" class="align-middle text-center">
                            {{ $item->priority }}
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>  
