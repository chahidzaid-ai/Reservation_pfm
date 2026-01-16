@extends('layouts.app')

@section('title', 'Rules & Guidelines')

@section('content')
<div class="card" style="background: white; padding: 2.5rem; border-radius: 12px; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.1); max-width: 900px; margin: 0 auto;">
    
    {{-- Header --}}
    <div style="border-bottom: 2px solid #f1f5f9; padding-bottom: 1.5rem; margin-bottom: 2rem;">
        <h1 style="color: #1e293b; margin: 0; font-size: 2rem;">
            <i class="fa-solid fa-scale-balanced" style="color: #2563eb;"></i> Rules & Guidelines
        </h1>
        <p style="color: #64748b; margin-top: 0.5rem;">Please read these terms carefully before reserving resources.</p>
    </div>

    {{-- Rules Content --}}
    <div style="color: #334155; line-height: 1.8;">
        
        <div style="margin-bottom: 2rem;">
            <h3 style="color: #1e293b; font-weight: 700; display: flex; align-items: center; gap: 10px;">
                <span style="background: #eff6ff; color: #2563eb; width: 30px; height: 30px; display: flex; align-items: center; justify-content: center; border-radius: 50%; font-size: 0.9rem;">1</span>
                Resource Usage
            </h3>
            <p style="margin-left: 40px; margin-top: 5px;">
                All reserved resources (servers, VMs, equipment) must be used strictly for <strong>professional or educational purposes</strong> defined in your request. Personal use, cryptocurrency mining, or hosting illegal content is strictly prohibited.
            </p>
        </div>

        <div style="margin-bottom: 2rem;">
            <h3 style="color: #1e293b; font-weight: 700; display: flex; align-items: center; gap: 10px;">
                <span style="background: #eff6ff; color: #2563eb; width: 30px; height: 30px; display: flex; align-items: center; justify-content: center; border-radius: 50%; font-size: 0.9rem;">2</span>
                Reservation Duration
            </h3>
            <p style="margin-left: 40px; margin-top: 5px;">
               Standard reservations should not exceed <strong>48 hours</strong>. If you require a longer duration, you must explicitly request it in the <strong>"Justification"</strong> field when submitting your reservation. Always release resources immediately after your task is complete to make them available for others.
            </p>
        </div>

        <div style="margin-bottom: 2rem;">
            <h3 style="color: #1e293b; font-weight: 700; display: flex; align-items: center; gap: 10px;">
                <span style="background: #eff6ff; color: #2563eb; width: 30px; height: 30px; display: flex; align-items: center; justify-content: center; border-radius: 50%; font-size: 0.9rem;">3</span>
                Incident Reporting
            </h3>
            <p style="margin-left: 40px; margin-top: 5px;">
                Any hardware failure, network outage, or software issue must be reported immediately via the <a href="{{ route('incidents.index') }}" style="color: #2563eb; text-decoration: underline;">Incidents tab</a>. Do not attempt to physically repair hardware yourself.
            </p>
        </div>

        {{-- NEW SANCTIONS SECTION --}}
        <div style="background-color: #fef2f2; border-left: 4px solid #ef4444; padding: 1.5rem; border-radius: 0 8px 8px 0; margin-top: 3rem;">
            <h3 style="color: #b91c1c; margin-top: 0; font-weight: 700; display: flex; align-items: center; gap: 10px;">
                <i class="fa-solid fa-gavel"></i> Sanctions & Enforcement
            </h3>
            <p style="color: #7f1d1d; margin-bottom: 1rem;">
                Failure to comply with the rules above will result in the following actions:
            </p>
            <ul style="color: #991b1b; margin: 0; padding-left: 1.5rem;">
                <li style="margin-bottom: 0.5rem;"><strong>First Offense:</strong> Formal warning and immediate cancellation of active reservations.</li>
                <li style="margin-bottom: 0.5rem;"><strong>Second Offense:</strong> Temporary account suspension (7 days) and review of access rights.</li>
                <li><strong>Severe Violation:</strong> Permanent account ban and report to administration.</li>
            </ul>
        </div>

    </div>
</div>
@endsection