<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Client Details - {{ $clientele->FirstName }} {{ $clientele->LastName }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            margin: 0;
            padding: 20px;
            color: #333;
        }
        .header {
            text-align: center;
            border-bottom: 2px solid #3B82F6;
            padding-bottom: 20px;
            margin-bottom: 30px;
        }
        .header h1 {
            color: #3B82F6;
            margin: 0;
            font-size: 28px;
        }
        .header p {
            margin: 5px 0 0 0;
            color: #666;
            font-size: 14px;
        }
        .client-info {
            background: #f8f9fa;
            padding: 20px;
            border-radius: 8px;
            margin-bottom: 30px;
        }
        .client-name {
            font-size: 24px;
            font-weight: bold;
            color: #1f2937;
            margin-bottom: 10px;
        }
        .client-code {
            color: #6b7280;
            font-size: 16px;
            margin-bottom: 20px;
        }
        .section {
            margin-bottom: 30px;
            page-break-inside: avoid;
        }
        .section-title {
            font-size: 18px;
            font-weight: bold;
            color: #3B82F6;
            border-bottom: 1px solid #e5e7eb;
            padding-bottom: 8px;
            margin-bottom: 15px;
        }
        .info-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
            margin-bottom: 20px;
        }
        .info-item {
            margin-bottom: 12px;
        }
        .info-label {
            font-weight: bold;
            color: #4b5563;
            font-size: 14px;
            margin-bottom: 3px;
        }
        .info-value {
            color: #1f2937;
            font-size: 14px;
        }
        .status-badge {
            display: inline-block;
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: bold;
            background: #10b981;
            color: white;
        }
        .loan-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
        }
        .loan-table th,
        .loan-table td {
            border: 1px solid #d1d5db;
            padding: 8px 12px;
            text-align: left;
            font-size: 12px;
        }
        .loan-table th {
            background: #f3f4f6;
            font-weight: bold;
            color: #374151;
        }
        .footer {
            margin-top: 40px;
            text-align: center;
            font-size: 12px;
            color: #6b7280;
            border-top: 1px solid #e5e7eb;
            padding-top: 20px;
        }
        .export-date {
            text-align: right;
            font-size: 12px;
            color: #6b7280;
            margin-bottom: 20px;
        }
        @media print {
            body {
                margin: 0;
                padding: 15px;
            }
            .header {
                page-break-after: avoid;
            }
        }
    </style>
</head>
<body>
    <div class="export-date">
        Generated on: {{ now()->format('F j, Y \a\t g:i A') }}
    </div>

    <div class="header">
        <h1>SAFADECO Cooperative</h1>
        <p>Client Information Report</p>
    </div>

    <div class="client-info">
        <div class="client-name">{{ $clientele->FirstName }} {{ $clientele->MiddleName }} {{ $clientele->LastName }}</div>
        <div class="client-code">Client Code: {{ $clientele->ClientCode }}</div>
        <span class="status-badge">Active Member</span>
    </div>

    <div class="section">
        <div class="section-title">Personal Information</div>
        <div class="info-grid">
            <div>
                <div class="info-item">
                    <div class="info-label">First Name</div>
                    <div class="info-value">{{ $clientele->FirstName ?: 'N/A' }}</div>
                </div>
                <div class="info-item">
                    <div class="info-label">Middle Name</div>
                    <div class="info-value">{{ $clientele->MiddleName ?: 'N/A' }}</div>
                </div>
                <div class="info-item">
                    <div class="info-label">Last Name</div>
                    <div class="info-value">{{ $clientele->LastName ?: 'N/A' }}</div>
                </div>
                <div class="info-item">
                    <div class="info-label">Date of Birth</div>
                    <div class="info-value">{{ $clientele->DtBirth ? \Carbon\Carbon::parse($clientele->DtBirth)->format('F j, Y') : 'N/A' }}</div>
                </div>
                <div class="info-item">
                    <div class="info-label">Gender</div>
                    <div class="info-value">{{ $clientele->Sex ? 'Male' : 'Female' }}</div>
                </div>
            </div>
            <div>
                <div class="info-item">
                    <div class="info-label">Client Type</div>
                    <div class="info-value">
                        @switch($clientele->ClientType)
                            @case(1) Regular Member @break
                            @case(2) Associate Member @break
                            @case(3) Honorary Member @break
                            @default Unknown
                        @endswitch
                    </div>
                </div>
                <div class="info-item">
                    <div class="info-label">Date of Membership</div>
                    <div class="info-value">{{ $clientele->DateOfMembership ? \Carbon\Carbon::parse($clientele->DateOfMembership)->format('F j, Y') : 'N/A' }}</div>
                </div>
                <div class="info-item">
                    <div class="info-label">Occupation</div>
                    <div class="info-value">{{ $clientele->Occupation ?: 'N/A' }}</div>
                </div>
                <div class="info-item">
                    <div class="info-label">Monthly Salary</div>
                    <div class="info-value">₱{{ number_format($clientele->MonthlySalary ?: 0, 2) }}</div>
                </div>
            </div>
        </div>
    </div>

    <div class="section">
        <div class="section-title">Contact Information</div>
        <div class="info-grid">
            <div>
                <div class="info-item">
                    <div class="info-label">Address</div>
                    <div class="info-value">{{ $clientele->Addr1 ?: 'N/A' }}</div>
                </div>
            </div>
            <div>
                <div class="info-item">
                    <div class="info-label">Phone Number</div>
                    <div class="info-value">{{ $clientele->TelNum ?: 'N/A' }}</div>
                </div>
            </div>
        </div>
    </div>

    @if($clientele->clienteleDetails)
    <div class="section">
        <div class="section-title">Additional Details</div>
        <div class="info-grid">
            <div>
                @if($clientele->clienteleDetails->SSS)
                <div class="info-item">
                    <div class="info-label">SSS Number</div>
                    <div class="info-value">{{ $clientele->clienteleDetails->SSS }}</div>
                </div>
                @endif
                @if($clientele->clienteleDetails->TIN)
                <div class="info-item">
                    <div class="info-label">TIN</div>
                    <div class="info-value">{{ $clientele->clienteleDetails->TIN }}</div>
                </div>
                @endif
                @if($clientele->clienteleDetails->Height)
                <div class="info-item">
                    <div class="info-label">Height</div>
                    <div class="info-value">{{ $clientele->clienteleDetails->Height }}</div>
                </div>
                @endif
                @if($clientele->clienteleDetails->Weight)
                <div class="info-item">
                    <div class="info-label">Weight</div>
                    <div class="info-value">{{ $clientele->clienteleDetails->Weight }}</div>
                </div>
                @endif
            </div>
            <div>
                @if($clientele->clienteleDetails->EmployerName)
                <div class="info-item">
                    <div class="info-label">Employer</div>
                    <div class="info-value">{{ $clientele->clienteleDetails->EmployerName }}</div>
                </div>
                @endif
                @if($clientele->clienteleDetails->OfficeAddress)
                <div class="info-item">
                    <div class="info-label">Office Address</div>
                    <div class="info-value">{{ $clientele->clienteleDetails->OfficeAddress }}</div>
                </div>
                @endif
                @if($clientele->clienteleDetails->Degree)
                <div class="info-item">
                    <div class="info-label">Educational Degree</div>
                    <div class="info-value">{{ $clientele->clienteleDetails->Degree }}</div>
                </div>
                @endif
            </div>
        </div>
    </div>
    @endif

    @if($clientele->SpouseName)
    <div class="section">
        <div class="section-title">Spouse Information</div>
        <div class="info-grid">
            <div>
                <div class="info-item">
                    <div class="info-label">Spouse Name</div>
                    <div class="info-value">{{ $clientele->SpouseName }}</div>
                </div>
                @if($clientele->SpouseOcc)
                <div class="info-item">
                    <div class="info-label">Spouse Occupation</div>
                    <div class="info-value">{{ $clientele->SpouseOcc }}</div>
                </div>
                @endif
            </div>
            <div>
                @if($clientele->SpouseMonSal)
                <div class="info-item">
                    <div class="info-label">Spouse Monthly Salary</div>
                    <div class="info-value">₱{{ number_format($clientele->SpouseMonSal, 2) }}</div>
                </div>
                @endif
                @if($clientele->clienteleDetails && $clientele->clienteleDetails->SpouseContactNo)
                <div class="info-item">
                    <div class="info-label">Spouse Contact</div>
                    <div class="info-value">{{ $clientele->clienteleDetails->SpouseContactNo }}</div>
                </div>
                @endif
            </div>
        </div>
    </div>
    @endif

    @if($loanApplications && $loanApplications->count() > 0)
    <div class="section">
        <div class="section-title">Loan Applications History</div>
        <table class="loan-table">
            <thead>
                <tr>
                    <th>Application Code</th>
                    <th>Date Applied</th>
                    <th>Loan Type</th>
                    <th>Loan Number</th>
                    <th>Status</th>
                    <th>Approved</th>
                    <th>Rating</th>
                </tr>
            </thead>
            <tbody>
                @foreach($loanApplications as $loan)
                <tr>
                    <td>{{ $loan->LACode }}</td>
                    <td>{{ $loan->DtOfApp ? \Carbon\Carbon::parse($loan->DtOfApp)->format('M j, Y') : 'N/A' }}</td>
                    <td>
                        @switch($loan->LoanType)
                            @case(1) Personal @break
                            @case(2) Business @break
                            @case(3) Emergency @break
                            @case(4) Educational @break
                            @case(5) Housing @break
                            @default Unknown
                        @endswitch
                    </td>
                    <td>{{ $loan->LoanNumber ?: 'N/A' }}</td>
                    <td>
                        @switch($loan->LoanStatus)
                            @case(1) Pending @break
                            @case(2) Approved @break
                            @case(3) Rejected @break
                            @case(4) Completed @break
                            @case(5) Cancelled @break
                            @default Unknown
                        @endswitch
                    </td>
                    <td>{{ $loan->Approved ? 'Yes' : 'No' }}</td>
                    <td>{{ $loan->RatingScore ?: 'N/A' }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    @endif

    <div class="footer">
        <p><strong>SAFADECO Cooperative</strong></p>
        <p>This document was generated automatically on {{ now()->format('F j, Y \a\t g:i A') }}</p>
        <p>For inquiries, please contact the cooperative office.</p>
    </div>
</body>
</html>
