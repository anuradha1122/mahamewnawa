<x-app-layout>
  <div class="py-3">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
          <x-breadcrumb :list="$option" />

          <x-search-heading heading="REPORTS" subheading="" />
          
          <div class="bg-white my-2 overflow-hidden shadow-sm sm:rounded-lg">
            <div class="grid grid-cols-2 gap-x-4 gap-y-6">
              <div class="p-2 text-gray-900">
                <x-dashboard-card icon="M12 6.042A8.967 8.967 0 0 0 6 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 0 1 6 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 0 1 6-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0 0 18 18a8.967 8.967 0 0 0-6 2.292m0-14.25v14.25" text="Project Payment Report" number="" linkid="{{ route('dambadiwa.project_payment_report') }}"/>
              </div>

              <div class="p-2 text-gray-900">
                <x-dashboard-card icon="M12 6.042A8.967 8.967 0 0 0 6 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 0 1 6 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 0 1 6-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0 0 18 18a8.967 8.967 0 0 0-6 2.292m0-14.25v14.25" text="Project User Payment Report" number="" linkid="{{ route('dambadiwa.project_user_payment_report') }}"/>
              </div>
            </div>
          </div>
      </div>
  </div>
</x-app-layout>