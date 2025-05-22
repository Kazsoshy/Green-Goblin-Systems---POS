@extends('layouts.admindash')

@section('title', 'Settings')
@section('header', 'Accessibility Settings')

@section('styles')
<style>
    .settings-card {
        background: white;
        border-radius: 12px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
    }

    .settings-section {
        padding: 2rem;
        border-bottom: 1px solid #eee;
    }

    .settings-section:last-child {
        border-bottom: none;
    }

    .settings-title {
        color: var(--primary-purple);
        font-weight: 600;
        margin-bottom: 1.5rem;
    }

    .form-group {
        margin-bottom: 1.5rem;
    }

    .form-group label {
        font-weight: 500;
        margin-bottom: 0.5rem;
        display: block;
    }

    .form-group select {
        width: 100%;
        padding: 0.5rem;
        border: 1px solid #ddd;
        border-radius: 6px;
        background-color: white;
    }

    .form-check {
        padding: 1rem;
        border: 1px solid #eee;
        border-radius: 8px;
        margin-bottom: 1rem;
        transition: all 0.3s ease;
    }

    .form-check:hover {
        background-color: #f8f9fa;
    }

    .form-check-input {
        margin-right: 1rem;
    }

    .form-check-label {
        font-weight: 500;
    }

    .form-text {
        color: #6c757d;
        font-size: 0.875rem;
        margin-top: 0.25rem;
    }

    .color-option {
        display: inline-block;
        width: 30px;
        height: 30px;
        border-radius: 50%;
        margin-right: 10px;
        cursor: pointer;
        border: 2px solid transparent;
    }

    .color-option.active {
        border-color: #333;
    }

    .color-option.default { background-color: #5E35B1; }
    .color-option.purple { background-color: #9C27B0; }
    .color-option.green { background-color: #2E7D32; }
    .color-option.blue { background-color: #1976D2; }

    .preview-box {
        padding: 1rem;
        border-radius: 8px;
        margin-top: 1rem;
        transition: all 0.3s ease;
    }

    .font-small { font-size: 14px; }
    .font-medium { font-size: 16px; }
    .font-large { font-size: 18px; }

    .high-contrast {
        background-color: #000 !important;
        color: #fff !important;
    }

    .reduced-motion * {
        transition: none !important;
        animation: none !important;
    }
</style>
@endsection

@section('content')
<div class="container py-4">
    @if(session('success'))
        <div class="alert alert-success mb-4">
            {{ session('success') }}
        </div>
    @endif

    <div class="settings-card">
        <form action="{{ route('settings_management.update') }}" method="POST">
            @csrf
            @method('PUT')

            <div class="settings-section">
                <h5 class="settings-title">Text Size</h5>
                <div class="form-group">
                    <label for="font_size">Select Font Size</label>
                    <select name="font_size" id="font_size" class="form-control">
                        <option value="small" {{ $settings->font_size === 'small' ? 'selected' : '' }}>Small</option>
                        <option value="medium" {{ $settings->font_size === 'medium' ? 'selected' : '' }}>Medium</option>
                        <option value="large" {{ $settings->font_size === 'large' ? 'selected' : '' }}>Large</option>
                    </select>
                    <div class="preview-box" id="font-preview">
                        Preview text with selected size
                    </div>
                </div>
            </div>

            <div class="settings-section">
                <h5 class="settings-title">Visual Preferences</h5>
                <div class="form-check">
                    <input type="checkbox" class="form-check-input" id="high_contrast" name="high_contrast" value="1" {{ $settings->high_contrast ? 'checked' : '' }}>
                    <label class="form-check-label" for="high_contrast">
                        High Contrast Mode
                    </label>
                    <div class="form-text">Increases contrast for better visibility</div>
                </div>

                <div class="form-check">
                    <input type="checkbox" class="form-check-input" id="reduce_motion" name="reduce_motion" value="1" {{ $settings->reduce_motion ? 'checked' : '' }}>
                    <label class="form-check-label" for="reduce_motion">
                        Reduce Motion
                    </label>
                    <div class="form-text">Minimizes animations and transitions</div>
                </div>
            </div>

            <div class="settings-section">
                <h5 class="settings-title">Theme Color</h5>
                <div class="form-group">
                    <div class="d-flex align-items-center mb-3">
                        <div class="color-option default {{ $settings->theme_color === 'default' ? 'active' : '' }}" data-color="default"></div>
                        <div class="color-option purple {{ $settings->theme_color === 'purple' ? 'active' : '' }}" data-color="purple"></div>
                        <div class="color-option green {{ $settings->theme_color === 'green' ? 'active' : '' }}" data-color="green"></div>
                        <div class="color-option blue {{ $settings->theme_color === 'blue' ? 'active' : '' }}" data-color="blue"></div>
                    </div>
                    <input type="hidden" name="theme_color" id="theme_color" value="{{ $settings->theme_color }}">
                </div>
            </div>

            <div class="settings-section">
                <button type="submit" class="btn btn-primary">Save Settings</button>
            </div>
        </form>
    </div>
</div>
@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Font size preview
    const fontPreview = document.getElementById('font-preview');
    const fontSelect = document.getElementById('font_size');

    function updateFontPreview() {
        fontPreview.className = 'preview-box font-' + fontSelect.value;
    }

    fontSelect.addEventListener('change', updateFontPreview);
    updateFontPreview();

    // Theme color selection
    const colorOptions = document.querySelectorAll('.color-option');
    const themeColorInput = document.getElementById('theme_color');

    colorOptions.forEach(option => {
        option.addEventListener('click', function() {
            // Remove active class from all options
            colorOptions.forEach(opt => opt.classList.remove('active'));
            // Add active class to clicked option
            this.classList.add('active');
            // Update hidden input value
            themeColorInput.value = this.dataset.color;
        });
    });

    // High contrast preview
    const highContrastCheck = document.getElementById('high_contrast');
    const previewBoxes = document.querySelectorAll('.preview-box');

    highContrastCheck.addEventListener('change', function() {
        previewBoxes.forEach(box => {
            if (this.checked) {
                box.classList.add('high-contrast');
            } else {
                box.classList.remove('high-contrast');
            }
        });
    });

    // Reduced motion preview
    const reduceMotionCheck = document.getElementById('reduce_motion');
    
    reduceMotionCheck.addEventListener('change', function() {
        if (this.checked) {
            document.body.classList.add('reduced-motion');
        } else {
            document.body.classList.remove('reduced-motion');
        }
    });
});
</script>
@endsection 