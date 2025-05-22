<!-- Order Receipt -->
<div class="w-[30%] fixed right-0 top-16 h-[calc(100vh-4rem)] bg-white shadow-lg flex flex-col">
    <div class="p-4 bg-white border-b flex-shrink-0">
        <h2 class="text-2xl font-bold">Order Receipt</h2>
    </div>
    <div class="flex-1 overflow-y-auto scrollbar-hide min-h-0">
        <div class="p-4">
            @yield('order-items')
        </div>
    </div>
    <div class="p-4 bg-white border-t flex-shrink-0">
        @yield('order-summary')
    </div>
</div> 