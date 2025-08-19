@extends('layouts.app')

@section('title', 'FAQs')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h4>FAQs</h4>
                        <a href="{{ route('faqs.create') }}" class="btn btn-primary btn-sm">Add New FAQ</a>
                    </div>

                    <div class="card-body">
                        @include('partials.alerts')

                        @if ($faqs->count())
                            <div class="table-responsive">
                                <table class="table table-bordered table-hover text-center mb-0">
                                    <thead class="thead-dark">
                                        <tr>
                                            <th style="width: 5%;">Sr. No</th>
                                            <th style="width: 45%;">Question</th>
                                            <th style="width: 40%;">Answer</th>
                                            <th style="width: 10%;">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($faqs as $faq)
                                            <tr>
                                                <td>{{ $loop->iteration + ($faqs->currentPage() - 1) * $faqs->perPage() }}
                                                </td>
                                                <td class="text-start">{{ $faq->question }}</td>
                                                <td class="text-start">{{ Str::limit(strip_tags($faq->answer), 100) }}</td>
                                                <td>
                                                    <x-table-actions route="faqs" :id="$faq->id" />
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>

                            <div class="mt-3">
                                {{ $faqs->links() }}
                            </div>
                        @else
                            <p class="text-center">No FAQs found.</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
