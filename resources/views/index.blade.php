@extends('layouts.app')

@section('content')
  <!-- Section Home -->
  <section id="home" class="py-16 relative z-[10]">
    <div class="bg-white/90 backdrop-blur-sm rounded-lg shadow-lg mx-auto max-w-7xl">
      @include('partials.home', ['slides' => $locations->map(function ($loc) {
        return [
            'image' => '/images/slider/slide1.png',
            'title' => $loc->name,
            'text' => "Pantau lalu lintas di {$loc->kecamatan} secara real-time."
        ];
      })->values()])
    </div>
  </section>

  <!-- Section Map -->
  <section id="map" class="py-16 max-w-7xl mx-auto relative z-[10]">
    <div class="bg-white/90 backdrop-blur-sm rounded-lg shadow-lg max-w-7xl mx-auto">
      @include('partials.map')
    </div>
  </section>

  <!-- Section Streaming -->
  <section id="streaming" class="py-16 max-w-7xl mx-auto relative z-[10]">
    <div class="bg-white/90 backdrop-blur-sm rounded-lg shadow-lg max-w-6xl mx-auto px-4">
      @include('partials.streaming', ['groupedByKecamatan' => $groupedByKecamatan])
    </div>
  </section>

  <!-- Section Kontak Kami -->
  <section id="contact" class="py-16 max-w-7xl mx-auto relative z-[10]">
    <div class="bg-white/90 backdrop-blur-sm rounded-lg shadow-lg max-w-7xl mx-auto px-4">
      @include('partials.contact', ['contacts' => $contacts])
    </div>
  </section>
@endsection
