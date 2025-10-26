<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <div class="card mb-4">
                        <div class="card-body">
                        <h5 class="mb-3">Promotion</h5>
                        <div class="row g-3">
                            <div class="col-md-4">
                            <div class="p-3 border bg-light rounded-3 text-center">Spend Over 5000 – Get 10% Off</div>
                            </div>
                            <div class="col-md-4">
                            <div class="p-3 border bg-light rounded-3 text-center">Only one promotion can be used per purchase.</div>
                            </div>
                            <div class="col-md-4">
                            <div class="p-3 border bg-light rounded-3 text-center">Buy 1 Get 1 Free</div>
                            </div>
                            <div class="col-md-6">
                            <div class="p-3 border bg-light rounded-3 text-center">Spend 1000 – Get 100฿ Off</div>
                            </div>
                        </div>
                        
                        <div class="card my-10">
                            <div class="card-body">
                                <h5 class="mb-3">Categories</h5>
                                <div class="d-flex flex-row-reverse flex-wrap gap-2">
                                    @foreach ($categories as $category)
                                        <a href="{{ url('/category/'.$category->id) }}">{{ $category->name }}</a>
                                    @endforeach

                                </div>
                            </div>
                        </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
