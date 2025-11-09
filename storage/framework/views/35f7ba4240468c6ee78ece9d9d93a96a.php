<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames(([
    'title' => 'Title',
    'value' => 0,
    'icon' => 'bar-chart',
    'color' => 'blue'
]));

foreach ($attributes->all() as $__key => $__value) {
    if (in_array($__key, $__propNames)) {
        $$__key = $$__key ?? $__value;
    } else {
        $__newAttributes[$__key] = $__value;
    }
}

$attributes = new \Illuminate\View\ComponentAttributeBag($__newAttributes);

unset($__propNames);
unset($__newAttributes);

foreach (array_filter(([
    'title' => 'Title',
    'value' => 0,
    'icon' => 'bar-chart',
    'color' => 'blue'
]), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
}

$__defined_vars = get_defined_vars();

foreach ($attributes->all() as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
}

unset($__defined_vars, $__key, $__value); ?>

<?php
    $colors = [
        'blue' => 'from-blue-500 to-blue-700',
        'green' => 'from-green-500 to-green-700',
        'purple' => 'from-purple-500 to-purple-700',
        'orange' => 'from-orange-500 to-orange-700',
    ];
?>

<div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-5 flex items-center justify-between hover:shadow-md transition-all duration-300">
    <div>
        <h3 class="text-sm font-medium text-gray-500"><?php echo e($title); ?></h3>
        <p class="text-3xl font-bold text-gray-900 mt-1"><?php echo e($value); ?></p>
    </div>

    <div class="p-3 rounded-full bg-gradient-to-br <?php echo e($colors[$color] ?? $colors['blue']); ?>">
        <i class="fa-solid fa-<?php echo e($icon); ?> text-white text-lg"></i>
    </div>
</div>
<?php /**PATH D:\xampp\htdocs\dih_website\resources\views/components/stat-card.blade.php ENDPATH**/ ?>