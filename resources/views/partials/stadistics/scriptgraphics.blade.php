<script>
    new Morris.Line({
        element: 'linechart',
        data: [
        @forelse($yearly as $y)
            { year:"{{$y->year}}", value:{{$y->ty}} },
        @empty
            { year:"2019", value:0 },
        @endforelse

        ],
        xkey: 'year',

        ykeys: ['value'],

        labels: ['Value']
    });

    new Morris.Bar({
        element: 'barchart',
        data: [
            @forelse($monthly as $m)
                { y:"{{$m->month}}", a:{{$m->tm}} },
            @empty
                { y:"1", a:0 },
            @endforelse
        ],
        xkey: 'y',
        ykeys: 'a',
        labels: 'Valor',
        barColors:[
        '#4a148c'
        ]
    });
    @if(auth()->user()->role->id == \App\Role::SUPERADMIN)
        new Morris.Donut({
            element: 'donutchart',
            data: [
                @forelse($users as $u)
                    {label:"{{$u->acronimo}}", value:{{$u->users_count}} },
                @empty
                    { label:"VACÍO", value:0 },
                @endforelse
            ],
            colors:[
            '#ff6d00',
            '#00e676',
            '#651fff'
            ]
        });
    @endif
</script>
