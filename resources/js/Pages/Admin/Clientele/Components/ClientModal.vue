<template>
    <div v-if="show" class="fixed inset-0 z-50 flex items-center justify-center bg-black/40 backdrop-blur-sm">
        <div class="bg-white/95 backdrop-blur-sm rounded-2xl shadow-2xl w-full max-w-4xl mx-4 max-h-[90vh] overflow-hidden">
            <!-- Header -->
            <div class="flex justify-between items-center p-5 border-b border-gray-200 bg-gradient-to-r from-blue-50 via-indigo-50 to-purple-50">
                <div class="flex items-center gap-3">
                    <div class="bg-gradient-to-br from-blue-500 to-purple-600 p-2.5 rounded-lg shadow-lg">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-lg font-bold text-gray-900">
                            {{ isEditing ? 'Edit Client' : 'Add New Client' }}
                        </h3>
                        <p class="text-sm text-gray-600">
                            {{ isEditing ? 'Update client information' : 'Register a new cooperative member' }}
                        </p>
                    </div>
                </div>
                <button 
                    @click="$emit('close')" 
                    class="text-gray-400 hover:text-gray-500 transition-colors duration-200 p-1 hover:bg-gray-100 rounded-full"
                >
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            <!-- Form Content -->
            <div class="overflow-y-auto max-h-[calc(90vh-140px)]">
                <form id="clientForm" @submit.prevent="handleSubmit" class="p-6">
                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                        <!-- Tabs Navigation -->
                        <div class="lg:col-span-2 border-b border-gray-200 bg-gray-50 rounded-t-lg">
                            <nav class="flex" aria-label="Tabs">
                                <button 
                                    v-for="(tab, index) in [
                                        { name: 'Basic Info', icon: 'M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z' },
                                        { name: 'Employment', icon: 'M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z' },
                                        { name: 'Family', icon: 'M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z' },
                                        { name: 'Membership', icon: 'M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4' },
                                        { name: 'Documents', icon: 'M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z' }
                                    ]" 
                                    :key="tab.name"
                                    @click="activeTab = tab.name"
                                    :class="[
                                        activeTab === tab.name 
                                            ? 'border-blue-500 text-blue-600 bg-white' 
                                            : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 hover:bg-gray-100',
                                        'flex-1 whitespace-nowrap py-3 px-3 border-b-2 font-medium text-sm flex items-center justify-center gap-2 transition-colors duration-200'
                                    ]"
                                    type="button"
                                >
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" :d="tab.icon" />
                                    </svg>
                                    {{ tab.name }}
                                </button>
                            </nav>
                        </div>

                        <!-- Basic Information Tab -->
                        <div v-show="activeTab === 'Basic Info'" class="lg:col-span-2">
                            <div class="lg:col-span-2">
                                <h4 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                    </svg>
                                    Personal Information
                                </h4>
                            </div>

                        <!-- Client Code -->
                        <div>
                            <label for="clientCode" class="block text-sm font-medium text-gray-700 mb-1">
                                Client Code <span class="text-red-500">*</span>
                            </label>
                            <input 
                                id="clientCode"
                                v-model="form.ClientCode" 
                                type="text" 
                                :disabled="isEditing"
                                required 
                                maxlength="10"
                                class="w-full px-3 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent disabled:bg-gray-100 disabled:text-gray-500"
                                placeholder="Enter unique client code"
                            >
                            <p class="text-xs text-gray-500 mt-1">Unique identifier for the client (max 10 characters)</p>
                        </div>

                        <!-- Client Type -->
                        <div>
                            <label for="clientType" class="block text-sm font-medium text-gray-700 mb-1">
                                Client Type <span class="text-red-500">*</span>
                            </label>
                            <select 
                                id="clientType"
                                v-model="form.ClientType" 
                                required
                                class="w-full px-3 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                            >
                                <option value="">Select client type</option>
                                <option value="1">Regular Member</option>
                                <option value="2">Associate Member</option>
                                <option value="3">Honorary Member</option>
                            </select>
                        </div>

                        <!-- First Name -->
                        <div>
                            <label for="firstName" class="block text-sm font-medium text-gray-700 mb-1">
                                First Name <span class="text-red-500">*</span>
                            </label>
                            <input 
                                id="firstName"
                                v-model="form.FirstName" 
                                type="text" 
                                required 
                                maxlength="70"
                                class="w-full px-3 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                placeholder="Enter first name"
                            >
                        </div>

                        <!-- Last Name -->
                        <div>
                            <label for="lastName" class="block text-sm font-medium text-gray-700 mb-1">
                                Last Name <span class="text-red-500">*</span>
                            </label>
                            <input 
                                id="lastName"
                                v-model="form.LastName" 
                                type="text" 
                                required 
                                maxlength="70"
                                class="w-full px-3 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                placeholder="Enter last name"
                            >
                        </div>

                        <!-- Middle Name -->
                        <div>
                            <label for="middleName" class="block text-sm font-medium text-gray-700 mb-1">
                                Middle Name
                            </label>
                            <input 
                                id="middleName"
                                v-model="form.MiddleName" 
                                type="text" 
                                maxlength="70"
                                class="w-full px-3 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                placeholder="Enter middle name (optional)"
                            >
                        </div>

                        <!-- Date of Birth -->
                        <div>
                            <label for="dtBirth" class="block text-sm font-medium text-gray-700 mb-1">
                                Date of Birth
                            </label>
                            <input 
                                id="dtBirth"
                                v-model="form.DtBirth" 
                                type="date" 
                                class="w-full px-3 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                            >
                        </div>

                        <!-- Sex -->
                        <div>
                            <label for="sex" class="block text-sm font-medium text-gray-700 mb-1">
                                Gender
                            </label>
                            <select 
                                id="sex"
                                v-model="form.Sex" 
                                class="w-full px-3 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                            >
                                <option value="">Select gender</option>
                                <option value="1">Male</option>
                                <option value="0">Female</option>
                            </select>
                        </div>

                        <!-- Membership Information Section -->
                        <div class="lg:col-span-2 mt-6">
                            <h4 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z" />
                                </svg>
                                Membership Information
                            </h4>
                        </div>

                        <!-- Date of Membership -->
                        <div>
                            <label for="dateOfMembership" class="block text-sm font-medium text-gray-700 mb-1">
                                Date of Membership <span class="text-red-500">*</span>
                            </label>
                            <input 
                                id="dateOfMembership"
                                v-model="form.DateOfMembership" 
                                type="date" 
                                required
                                class="w-full px-3 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                            >
                        </div>

                        <!-- Occupation -->
                        <div>
                            <label for="occupation" class="block text-sm font-medium text-gray-700 mb-1">
                                Occupation
                            </label>
                            <input 
                                id="occupation"
                                v-model="form.Occupation" 
                                type="text" 
                                maxlength="50"
                                class="w-full px-3 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                placeholder="Enter occupation"
                            >
                        </div>

                        <!-- Monthly Salary -->
                        <div>
                            <label for="monthlySalary" class="block text-sm font-medium text-gray-700 mb-1">
                                Monthly Salary
                            </label>
                            <div class="relative">
                                <span class="absolute left-3 top-3 text-gray-500">₱</span>
                                <input 
                                    id="monthlySalary"
                                    v-model="form.MonthlySalary" 
                                    type="number" 
                                    step="0.01"
                                    min="0"
                                    class="w-full pl-8 pr-3 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                    placeholder="0.00"
                                >
                            </div>
                        </div>

                        <!-- Contact Information Section -->
                        <div class="lg:col-span-2 mt-6">
                            <h4 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-purple-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                                </svg>
                                Contact Information
                            </h4>
                        </div>

                        <!-- Phone Number -->
                        <div>
                            <label for="telNum" class="block text-sm font-medium text-gray-700 mb-1">
                                Phone Number
                            </label>
                            <input 
                                id="telNum"
                                v-model="form.TelNum" 
                                type="tel" 
                                maxlength="64"
                                class="w-full px-3 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                placeholder="Enter phone number"
                            >
                        </div>

                        <!-- Address -->
                        <div>
                            <label for="addr1" class="block text-sm font-medium text-gray-700 mb-1">
                                Address
                            </label>
                            <input 
                                id="addr1"
                                v-model="form.Addr1" 
                                type="text" 
                                maxlength="150"
                                class="w-full px-3 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                placeholder="Enter complete address"
                            >
                        </div>

                        <!-- Additional Personal Information -->
                        <div class="lg:col-span-2 mt-6">
                            <h4 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                </svg>
                                Additional Information
                            </h4>
                        </div>

                        <!-- Height and Weight -->
                        <div>
                            <label for="height" class="block text-sm font-medium text-gray-700 mb-1">Height (cm)</label>
                            <input 
                                id="height"
                                v-model="form.Height" 
                                type="text" 
                                maxlength="10"
                                class="w-full px-3 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                placeholder="Enter height in cm"
                            >
                        </div>

                        <div>
                            <label for="weight" class="block text-sm font-medium text-gray-700 mb-1">Weight (kg)</label>
                            <input 
                                id="weight"
                                v-model="form.Weight" 
                                type="text"
                                maxlength="10"
                                class="w-full px-3 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                placeholder="Enter weight in kg"
                            >
                        </div>

                        <!-- SSS and TIN -->
                        <div>
                            <label for="sss" class="block text-sm font-medium text-gray-700 mb-1">SSS Number</label>
                            <input 
                                id="sss"
                                v-model="form.SSS" 
                                type="text" 
                                class="w-full px-3 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                placeholder="Enter SSS number"
                            >
                        </div>

                        <div>
                            <label for="tin" class="block text-sm font-medium text-gray-700 mb-1">TIN Number</label>
                            <input 
                                id="tin"
                                v-model="form.TIN" 
                                type="text" 
                                class="w-full px-3 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                placeholder="Enter TIN number"
                            >
                        </div>

                        <!-- Religion -->
                        <div>
                            <label for="religion" class="block text-sm font-medium text-gray-700 mb-1">Religion</label>
                            <input 
                                id="religion"
                                v-model="form.ReligionAffiliation" 
                                type="text" 
                                class="w-full px-3 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                placeholder="Enter religion"
                            >
                        </div>
                    </div>

                    <!-- Employment Tab -->
                    <div v-show="activeTab === 'Employment'" class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                        <div class="lg:col-span-2">
                            <h4 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                </svg>
                                Employment Information
                            </h4>
                        </div>

                        <!-- Employment Details -->
                        <div>
                            <label for="employerName" class="block text-sm font-medium text-gray-700 mb-1">Employer Name</label>
                            <input 
                                id="employerName"
                                v-model="form.EmployerName" 
                                type="text" 
                                class="w-full px-3 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                placeholder="Enter employer name"
                            >
                        </div>

                        <div>
                            <label for="department" class="block text-sm font-medium text-gray-700 mb-1">Department/Area</label>
                            <input 
                                id="department"
                                v-model="form.DepartmentOrArea" 
                                type="text" 
                                class="w-full px-3 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                placeholder="Enter department or area"
                            >
                        </div>

                        <div>
                            <label for="shift" class="block text-sm font-medium text-gray-700 mb-1">Shift</label>
                            <input 
                                id="shift"
                                v-model="form.Shift" 
                                type="text" 
                                class="w-full px-3 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                placeholder="Enter shift schedule"
                            >
                        </div>

                        <div>
                            <label for="localNo" class="block text-sm font-medium text-gray-700 mb-1">Local Number</label>
                            <input 
                                id="localNo"
                                v-model="form.LocalNo" 
                                type="text" 
                                class="w-full px-3 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                placeholder="Enter local number"
                            >
                        </div>

                        <!-- Office Address -->
                        <div class="lg:col-span-2">
                            <label for="officeAddress" class="block text-sm font-medium text-gray-700 mb-1">Office Address</label>
                            <input 
                                id="officeAddress"
                                v-model="form.OfficeAddress" 
                                type="text" 
                                class="w-full px-3 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                placeholder="Enter office address"
                            >
                        </div>

                        <div>
                            <label for="officeZip" class="block text-sm font-medium text-gray-700 mb-1">Office ZIP Code</label>
                            <input 
                                id="officeZip"
                                v-model="form.OfficeZip" 
                                type="text" 
                                class="w-full px-3 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                placeholder="Enter ZIP code"
                            >
                        </div>

                        <div>
                            <label for="officePhone" class="block text-sm font-medium text-gray-700 mb-1">Office Phone</label>
                            <input 
                                id="officePhone"
                                v-model="form.OfficePhone" 
                                type="tel" 
                                class="w-full px-3 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                placeholder="Enter office phone"
                            >
                        </div>

                        <!-- Education -->
                        <div>
                            <label for="degree" class="block text-sm font-medium text-gray-700 mb-1">Degree</label>
                            <input 
                                id="degree"
                                v-model="form.Degree" 
                                type="text" 
                                class="w-full px-3 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                placeholder="Enter degree"
                            >
                        </div>

                        <!-- Other Income Sources -->
                        <div>
                            <label for="otherIncome" class="block text-sm font-medium text-gray-700 mb-1">Other Source of Income</label>
                            <input 
                                id="otherIncome"
                                v-model="form.OtherSourceOfIncome" 
                                type="text" 
                                class="w-full px-3 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                placeholder="Enter other income source"
                            >
                        </div>

                        <div>
                            <label for="otherIncomeAmount" class="block text-sm font-medium text-gray-700 mb-1">Other Monthly Income</label>
                            <div class="relative">
                                <span class="absolute left-3 top-3 text-gray-500">₱</span>
                                <input 
                                    id="otherIncomeAmount"
                                    v-model="form.OtherSourceMonthlyIncome" 
                                    type="text"
                                    maxlength="20"
                                    class="w-full pl-8 pr-3 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                    placeholder="0.00"
                                >
                            </div>
                        </div>
                    </div>

                    <!-- Family Tab -->
                    <div v-show="activeTab === 'Family'" class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                        <!-- Spouse Information -->
                        <div class="lg:col-span-2">
                            <h4 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-pink-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                                </svg>
                                Spouse Information
                            </h4>
                        </div>

                        <div>
                            <label for="spouseContactNo" class="block text-sm font-medium text-gray-700 mb-1">Contact Number</label>
                            <input 
                                id="spouseContactNo"
                                v-model="form.SpouseContactNo" 
                                type="tel" 
                                class="w-full px-3 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                placeholder="Enter spouse's contact number"
                            >
                        </div>

                        <div>
                            <label for="spouseBirthday" class="block text-sm font-medium text-gray-700 mb-1">Birthday</label>
                            <input 
                                id="spouseBirthday"
                                v-model="form.SpouseBirthday" 
                                type="date" 
                                class="w-full px-3 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                            >
                        </div>

                        <div>
                            <label for="spouseEducation" class="block text-sm font-medium text-gray-700 mb-1">Educational Attainment</label>
                            <input 
                                id="spouseEducation"
                                v-model="form.SpouseEducationalAttaintment" 
                                type="text" 
                                class="w-full px-3 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                placeholder="Enter spouse's education"
                            >
                        </div>

                        <div>
                            <label for="spouseDegree" class="block text-sm font-medium text-gray-700 mb-1">Degree</label>
                            <input 
                                id="spouseDegree"
                                v-model="form.SpouseDegree" 
                                type="text" 
                                class="w-full px-3 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                placeholder="Enter spouse's degree"
                            >
                        </div>

                        <div>
                            <label for="spouseEmployer" class="block text-sm font-medium text-gray-700 mb-1">Employer</label>
                            <input 
                                id="spouseEmployer"
                                v-model="form.SpouseEmployer" 
                                type="text" 
                                class="w-full px-3 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                placeholder="Enter spouse's employer"
                            >
                        </div>

                        <div>
                            <label for="spouseOfficeAddress" class="block text-sm font-medium text-gray-700 mb-1">Office Address</label>
                            <input 
                                id="spouseOfficeAddress"
                                v-model="form.SpouseOfficeAddress" 
                                type="text" 
                                class="w-full px-3 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                placeholder="Enter spouse's office address"
                            >
                        </div>

                        <!-- Parents Information -->
                        <div class="lg:col-span-2 mt-6">
                            <h4 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-yellow-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                                </svg>
                                Parents Information
                            </h4>
                        </div>

                        <!-- Father's Information -->
                        <div>
                            <label for="fatherName" class="block text-sm font-medium text-gray-700 mb-1">Father's Name</label>
                            <input 
                                id="fatherName"
                                v-model="form.FatherName" 
                                type="text" 
                                class="w-full px-3 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                placeholder="Enter father's name"
                            >
                        </div>

                        <div>
                            <label for="fatherOcc" class="block text-sm font-medium text-gray-700 mb-1">Father's Occupation</label>
                            <input 
                                id="fatherOcc"
                                v-model="form.FatherOcc" 
                                type="text" 
                                class="w-full px-3 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                placeholder="Enter father's occupation"
                            >
                        </div>

                        <div>
                            <label for="fatherBirthday" class="block text-sm font-medium text-gray-700 mb-1">Father's Birthday</label>
                            <input 
                                id="fatherBirthday"
                                v-model="form.FatherBirthday" 
                                type="date" 
                                class="w-full px-3 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                            >
                        </div>

                        <div>
                            <label for="fatherOfficeAddress" class="block text-sm font-medium text-gray-700 mb-1">Father's Office Address</label>
                            <input 
                                id="fatherOfficeAddress"
                                v-model="form.FatherOfficeAddress" 
                                type="text" 
                                class="w-full px-3 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                placeholder="Enter father's office address"
                            >
                        </div>

                        <!-- Mother's Information -->
                        <div>
                            <label for="motherName" class="block text-sm font-medium text-gray-700 mb-1">Mother's Name</label>
                            <input 
                                id="motherName"
                                v-model="form.MotherName" 
                                type="text" 
                                class="w-full px-3 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                placeholder="Enter mother's name"
                            >
                        </div>

                        <div>
                            <label for="motherOcc" class="block text-sm font-medium text-gray-700 mb-1">Mother's Occupation</label>
                            <input 
                                id="motherOcc"
                                v-model="form.MotherOcc" 
                                type="text" 
                                class="w-full px-3 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                placeholder="Enter mother's occupation"
                            >
                        </div>

                        <div>
                            <label for="motherBirthday" class="block text-sm font-medium text-gray-700 mb-1">Mother's Birthday</label>
                            <input 
                                id="motherBirthday"
                                v-model="form.MotherBirthday" 
                                type="date" 
                                class="w-full px-3 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                            >
                        </div>
                    </div>

                    <!-- Membership Tab -->
                    <div v-show="activeTab === 'Membership'" class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                        <div class="lg:col-span-2">
                            <h4 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-indigo-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                                </svg>
                                Membership Details
                            </h4>
                        </div>

                        <!-- Membership Entry -->
                        <div>
                            <label for="membershipEntry" class="block text-sm font-medium text-gray-700 mb-1">Membership Entry</label>
                            <input 
                                id="membershipEntry"
                                v-model="form.MembershipEntry" 
                                type="text"
                                maxlength="5"
                                class="w-full px-3 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                placeholder="Enter membership entry"
                            >
                        </div>

                        <!-- Pre-orientation Date -->
                        <div>
                            <label for="preOrientationDate" class="block text-sm font-medium text-gray-700 mb-1">Pre-orientation Date</label>
                            <input 
                                id="preOrientationDate"
                                v-model="form.PreOrientationDate" 
                                type="date" 
                                class="w-full px-3 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                            >
                        </div>

                        <!-- Orientation Conductor -->
                        <div>
                            <label for="orientationConductor" class="block text-sm font-medium text-gray-700 mb-1">Orientation Conducted By</label>
                            <input 
                                id="orientationConductor"
                                v-model="form.MembershipOrientationConductedby" 
                                type="text" 
                                class="w-full px-3 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                placeholder="Enter conductor's name"
                            >
                        </div>

                        <!-- Membership Status -->
                        <div>
                            <label for="membershipStatus" class="block text-sm font-medium text-gray-700 mb-1">Membership Status</label>
                            <select 
                                id="membershipStatus"
                                v-model="form.MembershipStatus" 
                                maxlength="10"
                                class="w-full px-3 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                            >
                                <option value="">Select status</option>
                                <option value="ACT">ACT</option>
                                <option value="INAC">INAC</option>
                                <option value="PEND">PEND</option>
                                <option value="TERM">TERM</option>
                            </select>
                        </div>

                        <!-- BOD Resolution Details -->
                        <div>
                            <label for="bodResNo" class="block text-sm font-medium text-gray-700 mb-1">BOD Resolution Number</label>
                            <input 
                                id="bodResNo"
                                v-model="form.BODResNo" 
                                type="text" 
                                class="w-full px-3 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                placeholder="Enter BOD resolution number"
                            >
                        </div>

                        <div>
                            <label for="dateApproved" class="block text-sm font-medium text-gray-700 mb-1">Date Approved</label>
                            <input 
                                id="dateApproved"
                                v-model="form.DateApproved" 
                                type="date" 
                                class="w-full px-3 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                            >
                        </div>

                        <!-- Shares Information -->
                        <div>
                            <label for="initCapSubs" class="block text-sm font-medium text-gray-700 mb-1">Initial Capital Subscription</label>
                            <div class="relative">
                                <span class="absolute left-3 top-3 text-gray-500">₱</span>
                                <input 
                                    id="initCapSubs"
                                    v-model="form.InitCapSubs" 
                                    type="number"
                                    step="0.01" 
                                    class="w-full pl-8 pr-3 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                    placeholder="0.00"
                                >
                            </div>
                        </div>

                        <div>
                            <label for="noOfShares" class="block text-sm font-medium text-gray-700 mb-1">Number of Shares</label>
                            <input 
                                id="noOfShares"
                                v-model="form.NoOfShares" 
                                type="number" 
                                min="0"
                                class="w-full px-3 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                placeholder="Enter number of shares"
                            >
                        </div>

                        <div>
                            <label for="amountSubs" class="block text-sm font-medium text-gray-700 mb-1">Amount Subscribed</label>
                            <div class="relative">
                                <span class="absolute left-3 top-3 text-gray-500">₱</span>
                                <input 
                                    id="amountSubs"
                                    v-model="form.amountSubs" 
                                    type="number"
                                    step="0.01" 
                                    class="w-full pl-8 pr-3 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                    placeholder="0.00"
                                >
                            </div>
                        </div>

                        <!-- Membership Fee -->
                        <div>
                            <label for="mFeeAmt" class="block text-sm font-medium text-gray-700 mb-1">
                                Membership Fee <span class="text-red-500">*</span>
                            </label>
                            <div class="relative">
                                <span class="absolute left-3 top-3 text-gray-500">₱</span>
                                <input 
                                    id="mFeeAmt"
                                    v-model="form.MFee_amt" 
                                    type="number"
                                    step="0.01"
                                    required
                                    class="w-full pl-8 pr-3 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                    placeholder="0.00"
                                >
                            </div>
                        </div>

                        <!-- Max Share Capital -->
                        <div>
                            <label for="maxShareCapital" class="block text-sm font-medium text-gray-700 mb-1">
                                Max Share Capital <span class="text-red-500">*</span>
                            </label>
                            <div class="relative">
                                <span class="absolute left-3 top-3 text-gray-500">₱</span>
                                <input 
                                    id="maxShareCapital"
                                    v-model="form.MaxShareCapital" 
                                    type="number"
                                    step="0.01"
                                    required
                                    class="w-full pl-8 pr-3 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                    placeholder="0.00"
                                >
                            </div>
                        </div>

                        <!-- Termination Details -->
                        <div>
                            <label for="bodResNoTerminate" class="block text-sm font-medium text-gray-700 mb-1">BOD Resolution Number (Termination)</label>
                            <input 
                                id="bodResNoTerminate"
                                v-model="form.BodResNoTerminate" 
                                type="text" 
                                class="w-full px-3 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                placeholder="Enter termination resolution number"
                            >
                        </div>
                    </div>

                    <!-- Documents Tab -->
                    <div v-show="activeTab === 'Documents'" class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                        <div class="lg:col-span-2">
                            <h4 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-gray-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                                Documents
                            </h4>
                        </div>

                        <!-- Photo Upload -->
                        <div>
                            <label for="imagePhoto" class="block text-sm font-medium text-gray-700 mb-1">Photo</label>
                            <input 
                                id="imagePhoto"
                                type="file" 
                                accept="image/*"
                                @change="handlePhotoUpload"
                                class="w-full px-3 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                            >
                            <p class="text-xs text-gray-500 mt-1">Upload a clear photo of the member</p>
                        </div>

                        <!-- Signature Upload -->
                        <div>
                            <label for="imageSignature" class="block text-sm font-medium text-gray-700 mb-1">Signature</label>
                            <input 
                                id="imageSignature"
                                type="file" 
                                accept="image/*"
                                @change="handleSignatureUpload"
                                class="w-full px-3 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                            >
                            <p class="text-xs text-gray-500 mt-1">Upload a clear image of the member's signature</p>
                        </div>
                    </div>

                    </div>
                </form>
            </div>

            <!-- Fixed Form Actions at Bottom -->
            <div class="sticky bottom-0 left-0 right-0 bg-white border-t border-gray-200 p-4 shadow-lg">
                <div class="flex justify-end gap-3 max-w-4xl mx-auto">
                    <button 
                        type="button" 
                        @click="$emit('close')" 
                        class="px-4 py-2 text-sm border border-gray-300 text-gray-700 rounded-md hover:bg-gray-50 transition-colors duration-200 font-medium focus:outline-none focus:ring-2 focus:ring-gray-200 focus:ring-offset-2"
                    >
                        <span class="flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                            Cancel
                        </span>
                    </button>
                    <button 
                        type="submit"
                        form="clientForm"
                        :disabled="isSubmitting"
                        class="px-4 py-2 text-sm bg-blue-600 text-white rounded-md hover:bg-blue-700 transition-colors duration-200 font-medium disabled:opacity-50 disabled:cursor-not-allowed flex items-center focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2"
                    >
                        <svg v-if="isSubmitting" xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1.5 animate-spin" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                        </svg>
                        <svg v-else xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                        </svg>
                        {{ isSubmitting ? 'Saving...' : (isEditing ? 'Update Client' : 'Create Client') }}
                    </button>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import { ref, watch, onMounted } from 'vue';

const props = defineProps({
    show: Boolean,
    client: Object,
    isEditing: Boolean
});

const emit = defineEmits(['close', 'submit']);

const isSubmitting = ref(false);
const activeTab = ref('Basic Info');
const form = ref({
    // Basic Information
    ClientCode: '',
    LastName: '',
    FirstName: '',
    MiddleName: '',
    DateOfMembership: '',
    ClientType: '',
    Addr1: '',
    TelNum: '',
    DtBirth: '',
    Sex: '',
    MonthlySalary: '',
    Occupation: '',
    
    // Additional Personal Information
    Height: '',
    Weight: '',
    SSS: '',
    TIN: '',
    ReligionAffiliation: '',
    
    // Employment Information
    Shift: '',
    DepartmentOrArea: '',
    LocalNo: '',
    Degree: '',
    EmployerName: '',
    OfficeAddress: '',
    OfficeZip: '',
    OfficePhone: '',
    
    // Additional Income Information
    OtherSourceOfIncome: '',
    OtherSourceMonthlyIncome: '',
    
    // Spouse Information
    SpouseContactNo: '',
    SpouseBirthday: '',
    SpouseEducationalAttaintment: '',
    SpouseDegree: '',
    SpouseEmployer: '',
    SpouseOfficeAddress: '',
    
    // Parents Information
    FatherName: '',
    FatherOcc: '',
    FatherBirthday: '',
    FatherOfficeAddress: '',
    MotherName: '',
    MotherOcc: '',
    MotherBirthday: '',
    
    // Membership Details
    MembershipEntry: '',
    PreOrientationDate: '',
    MembershipOrientationConductedby: '',
    MembershipStatus: '',
    BODResNo: '',
    DateApproved: '',
    InitCapSubs: '',
    NoOfShares: '',
    amountSubs: '',
    BodResNoTerminate: '',
    MFee_amt: '0',
    MaxShareCapital: '0',
    
    // Images
    ImagePhoto: '',
    ImageSignature: ''
});

// Format date for input field
const formatDateForInput = (dateString) => {
    if (!dateString) return '';
    const date = new Date(dateString);
    return date.toISOString().split('T')[0];
};

// Watch for client prop changes to populate form
watch(() => props.client, (newClient) => {
    if (newClient) {
        form.value = {
            // Basic Information
            ClientCode: newClient.ClientCode || '',
            LastName: newClient.LastName || '',
            FirstName: newClient.FirstName || '',
            MiddleName: newClient.MiddleName || '',
            DateOfMembership: formatDateForInput(newClient.DateOfMembership),
            ClientType: newClient.ClientType || '',
            Addr1: newClient.Addr1 || '',
            TelNum: newClient.TelNum || '',
            DtBirth: formatDateForInput(newClient.DtBirth),
            Sex: newClient.Sex !== null ? newClient.Sex.toString() : '',
            MonthlySalary: newClient.MonthlySalary || '',
            Occupation: newClient.Occupation || '',
            
            // Additional Personal Information
            Height: newClient.Height || '',
            Weight: newClient.Weight || '',
            SSS: newClient.SSS || '',
            TIN: newClient.TIN || '',
            ReligionAffiliation: newClient.ReligionAffiliation || '',
            
            // Employment Information
            Shift: newClient.Shift || '',
            DepartmentOrArea: newClient.DepartmentOrArea || '',
            LocalNo: newClient.LocalNo || '',
            Degree: newClient.Degree || '',
            EmployerName: newClient.EmployerName || '',
            OfficeAddress: newClient.OfficeAddress || '',
            OfficeZip: newClient.OfficeZip || '',
            OfficePhone: newClient.OfficePhone || '',
            
            // Additional Income Information
            OtherSourceOfIncome: newClient.OtherSourceOfIncome || '',
            OtherSourceMonthlyIncome: newClient.OtherSourceMonthlyIncome || '',
            
            // Spouse Information
            SpouseContactNo: newClient.SpouseContactNo || '',
            SpouseBirthday: formatDateForInput(newClient.SpouseBirthday),
            SpouseEducationalAttaintment: newClient.SpouseEducationalAttaintment || '',
            SpouseDegree: newClient.SpouseDegree || '',
            SpouseEmployer: newClient.SpouseEmployer || '',
            SpouseOfficeAddress: newClient.SpouseOfficeAddress || '',
            
            // Parents Information
            FatherName: newClient.FatherName || '',
            FatherOcc: newClient.FatherOcc || '',
            FatherBirthday: formatDateForInput(newClient.FatherBirthday),
            FatherOfficeAddress: newClient.FatherOfficeAddress || '',
            MotherName: newClient.MotherName || '',
            MotherOcc: newClient.MotherOcc || '',
            MotherBirthday: formatDateForInput(newClient.MotherBirthday),
            
            // Membership Details
            MembershipEntry: newClient.MembershipEntry || '',
            PreOrientationDate: formatDateForInput(newClient.PreOrientationDate),
            MembershipOrientationConductedby: newClient.MembershipOrientationConductedby || '',
            MembershipStatus: newClient.MembershipStatus || '',
            BODResNo: newClient.BODResNo || '',
            DateApproved: formatDateForInput(newClient.DateApproved),
            InitCapSubs: newClient.InitCapSubs || '',
            NoOfShares: newClient.NoOfShares || '',
            amountSubs: newClient.amountSubs || '',
            BodResNoTerminate: newClient.BodResNoTerminate || '',
            MFee_amt: newClient.MFee_amt || '0',
            MaxShareCapital: newClient.MaxShareCapital || '0',
            
            // Images
            ImagePhoto: newClient.ImagePhoto || '',
            ImageSignature: newClient.ImageSignature || ''
        };
    } else {
        // Reset form for new client
        form.value = {
            // Basic Information
            ClientCode: '',
            LastName: '',
            FirstName: '',
            MiddleName: '',
            DateOfMembership: '',
            ClientType: '',
            Addr1: '',
            TelNum: '',
            DtBirth: '',
            Sex: '',
            MonthlySalary: '',
            Occupation: '',
            
            // Additional Personal Information
            Height: '',
            Weight: '',
            SSS: '',
            TIN: '',
            ReligionAffiliation: '',
            
            // Employment Information
            Shift: '',
            DepartmentOrArea: '',
            LocalNo: '',
            Degree: '',
            EmployerName: '',
            OfficeAddress: '',
            OfficeZip: '',
            OfficePhone: '',
            
            // Additional Income Information
            OtherSourceOfIncome: '',
            OtherSourceMonthlyIncome: '',
            
            // Spouse Information
            SpouseContactNo: '',
            SpouseBirthday: '',
            SpouseEducationalAttaintment: '',
            SpouseDegree: '',
            SpouseEmployer: '',
            SpouseOfficeAddress: '',
            
            // Parents Information
            FatherName: '',
            FatherOcc: '',
            FatherBirthday: '',
            FatherOfficeAddress: '',
            MotherName: '',
            MotherOcc: '',
            MotherBirthday: '',
            
            // Membership Details
            MembershipEntry: '',
            PreOrientationDate: '',
            MembershipOrientationConductedby: '',
            MembershipStatus: '',
            BODResNo: '',
            DateApproved: '',
            InitCapSubs: '',
            NoOfShares: '',
            amountSubs: '',
            BodResNoTerminate: '',
            
            // Images
            ImagePhoto: '',
            ImageSignature: ''
        };
    }
}, { immediate: true });

const handlePhotoUpload = (event) => {
    const file = event.target.files[0];
    if (file) {
        // Convert to base64 for preview and storage
        const reader = new FileReader();
        reader.onload = (e) => {
            form.value.ImagePhoto = e.target.result;
        };
        reader.readAsDataURL(file);
    }
};

const handleSignatureUpload = (event) => {
    const file = event.target.files[0];
    if (file) {
        // Convert to base64 for preview and storage
        const reader = new FileReader();
        reader.onload = (e) => {
            form.value.ImageSignature = e.target.result;
        };
        reader.readAsDataURL(file);
    }
};

const handleSubmit = async () => {
    isSubmitting.value = true;
    
    // Prepare form data with proper formatting
    const formData = {
        ...form.value,
        ClientType: parseInt(form.value.ClientType) || null,
        Sex: form.value.Sex !== '' ? parseInt(form.value.Sex) : null,
        MonthlySalary: form.value.MonthlySalary ? parseFloat(form.value.MonthlySalary) : null,
        Height: form.value.Height ? form.value.Height.toString() : null,
        Weight: form.value.Weight ? form.value.Weight.toString() : null,
        OtherSourceMonthlyIncome: form.value.OtherSourceMonthlyIncome ? form.value.OtherSourceMonthlyIncome.toString() : null
    };
    
    // Remove empty strings and convert to null
    Object.keys(formData).forEach(key => {
        if (formData[key] === '') {
            formData[key] = null;
        }
    });
    
    emit('submit', formData);
    
    // Reset submitting state after a delay
    setTimeout(() => {
        isSubmitting.value = false;
    }, 1000);
};

// Generate client code when creating new client
const generateClientCode = () => {
    if (!props.isEditing && !form.value.ClientCode) {
        const timestamp = Date.now().toString().slice(-6);
        form.value.ClientCode = `CL${timestamp}`;
    }
};

onMounted(() => {
    if (!props.isEditing) {
        generateClientCode();
    }
});
</script>

<style scoped>
.animate-spin {
    animation: spin 1s linear infinite;
}

@keyframes spin {
    from { transform: rotate(0deg); }
    to { transform: rotate(360deg); }
}
</style>
