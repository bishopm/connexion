<div class="modal fade modal-primary" id="modal-giving" tabindex="-1" role="dialog" aria-labelledby="delete-confirmation-title" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h3 class="modal-title" id="delete-confirmation-title">Planned giving at {{$setting['site_abbreviation']}}</h3>
            </div>
            <div class="modal-body">
                Thank you for considering signing up for planned giving!. This is something we encourage all our members to do to:
                <ul class="top20">
                    <li>Help make giving to God a regular worship practice in our lives</li>
                    <li>Fund ministry and enable the church to plan more confidently</li>
                    <li>Facilitate anonymous giving, while still ensuring that the church acknowledges amounts received</li>
                </ul>
                Click on a button below to choose from the available PG numbers:
                <div class="row">
                    <div class="col-md-8">
                        <table class="table table-condensed table-responsive top10">
                            @foreach ($pg as $key=>$p)
                                @if (intval($key) % 8 ==0)
                                    <tr>
                                @endif
                                    <td class="text-center"><a class="addPg btn btn-default btn-xs">{{$p}}</a></td>
                                @if (intval($key+1) % 8 ==0)
                                    </tr>
                                @endif
                            @endforeach
                        </table>
                    </div>
                    <div class="col-md-4">
                        @if (count($householdpgs))
                            <div class="panel-body small">A member of your houshold already has a PG number. Click the button below to use that number as your number too:
                                @foreach ($householdpgs as $hpg)
                                    <td class="text-center"><a class="addPg btn btn-default btn-xs">{{$hpg}}</a></td>
                                @endforeach
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>