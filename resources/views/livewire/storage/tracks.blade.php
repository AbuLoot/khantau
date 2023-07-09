<div>
  <div class="px-3 py-3 border-bottom mb-3">
    <div class="container d-flex flex-wrap justify-content-between align-items-center">

      <h4 class="col-12 col-lg-4 mb-md-2 mb-lg-0">Tracks</h4>

      <form class="col-12 col-lg-4 mb-md-2 mb-lg-0 me-lg-auto">
        <input wire:model="search" type="search" class="form-control form-control-lg" placeholder="Enter track code..." aria-label="Search">
      </form>

    </div>
  </div>

  <div class="container">
    <div class="row">
      <div class="col-12 col-sm-12">

        <p><b>Count {{ $tracksCount }}pcs</b> @if($tracksStatus) | <b>{{ ucfirst($statuses->where('id', $tracksStatus)->first()->slug) }} tracks</b> @endif</p>

        @foreach($tracks as $track)
          <div class="track-item mb-2">
            <?php
              $activeStatus = $track->statuses->last();

              $arrivalOrGivenRegion = null;
              $givenIcon = [
                'added' => null,
                'received' => null,
                'sent' => null,
                'waiting' => null,
                'arrived' => null,
                'given' => '<i class="bi bi-person-check-fill"></i>',
              ];

              if (in_array($activeStatus->slug, ['arrived', 'given']) OR in_array($activeStatus->id, [5, 6])) {

                $arrivalOrGivenRegion = $track->regions->last()->title ?? __('statuses.regions.title');
                $arrivalOrGivenRegion = '('.$arrivalOrGivenRegion.', Казахстан)';
              }
            ?>
            <div class="border {{ __('statuses.classes.'.$activeStatus->slug.'.card-color') }} rounded-top p-2" data-bs-toggle="collapse" href="#collapse{{ $track->id }}">
              <div class="row">
                <div class="col-12 col-lg-5">
                  <div><b>Track code:</b> {{ $track->code }}</div>
                  <div><b>Description:</b> {{ Str::limit($track->description, 35) }}</div>
                </div>
                <div class="col-12 col-lg-4">
                  <div><b>{{ ucfirst($activeStatus->slug) }}:</b> {{ $activeStatus->pivot->created_at }}</div>
                  <div>
                    <b>Status: {!! $givenIcon[$activeStatus->slug] !!}</b> {{ $activeStatus->title }} {{ $arrivalOrGivenRegion }}
                  </div>
                </div>
                @if($track->user)
                  <div class="col-12 col-lg-3">
                    <b>User:</b> {{ $track->user->name.' '.$track->user->lastname }}<br>
                    <b>ID:</b> {{ $track->user->id_client }}
                  </div>
                @endif
              </div>
            </div>

            <div class="collapse" id="collapse{{ $track->id }}">
              <div class="border border-top-0 rounded-bottom p-3">
                <section>
                  <ul class="timeline-with-icons">
                    @foreach($track->statuses()->orderByDesc('id')->get() as $status)

                      @if($activeStatus->id == $status->id)
                        <li class="timeline-item mb-2">
                          <span class="timeline-icon bg-success"><i class="bi bi-check text-white"></i></span>
                          <p class="text-success mb-0">{{ $status->title }} {{ $arrivalOrGivenRegion }}</p>
                          <p class="text-success mb-0">{{ $status->pivot->created_at }}</p>
                        </li>
                        @continue
                      @endif

                      <li class="timeline-item mb-2">
                        <span class="timeline-icon bg-secondary"><i class="bi bi-check text-white"></i></span>
                        <p class="text-body mb-0">{{ $status->title }}</p>
                        <p class="text-body mb-0">{{ $status->pivot->created_at }}</p>
                      </li>
                    @endforeach
                  </ul>
                  <p><b>Description:</b> {{ $track->description }}</p>
                </section>
              </div>
            </div>
          </div>
        @endforeach

      </div>
    </div>

    <br>
    <nav aria-label="Page navigation">
      {{ $tracks->links() }}
    </nav>
  </div>

</div>
