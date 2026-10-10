import 'package:flutter/material.dart';

void main() => runApp(const ConverterApp());

class ConverterApp extends StatelessWidget {
  const ConverterApp({super.key});

  @override
  Widget build(BuildContext context) => MaterialApp(
        title: 'Convertisseur HTG/USD',
        theme: ThemeData(colorSchemeSeed: Colors.indigo, useMaterial3: true),
        home: const ConverterPage(),
      );
}

class ConverterPage extends StatefulWidget {
  const ConverterPage({super.key});

  @override
  State<ConverterPage> createState() => _ConverterPageState();
}

class _ConverterPageState extends State<ConverterPage> {
  final _amount = TextEditingController();
  final _rate = TextEditingController(text: '130'); // HTG pour 1 USD, modifiable
  bool _usdToHtg = true;

  double? get _result {
    final amount = double.tryParse(_amount.text.replaceAll(',', '.'));
    final rate = double.tryParse(_rate.text.replaceAll(',', '.'));
    if (amount == null || rate == null || rate <= 0) return null;
    return _usdToHtg ? amount * rate : amount / rate;
  }

  @override
  void dispose() {
    _amount.dispose();
    _rate.dispose();
    super.dispose();
  }

  @override
  Widget build(BuildContext context) {
    final from = _usdToHtg ? 'USD' : 'HTG';
    final to = _usdToHtg ? 'HTG' : 'USD';
    final result = _result;

    return Scaffold(
      appBar: AppBar(title: const Text('Convertisseur HTG / USD')),
      body: Padding(
        padding: const EdgeInsets.all(20),
        child: Column(
          children: [
            TextField(
              controller: _rate,
              keyboardType: const TextInputType.numberWithOptions(decimal: true),
              decoration: const InputDecoration(
                labelText: 'Taux : 1 USD = ... HTG',
                border: OutlineInputBorder(),
              ),
              onChanged: (_) => setState(() {}),
            ),
            const SizedBox(height: 16),
            TextField(
              controller: _amount,
              keyboardType: const TextInputType.numberWithOptions(decimal: true),
              decoration: InputDecoration(
                labelText: 'Montant en $from',
                border: const OutlineInputBorder(),
              ),
              onChanged: (_) => setState(() {}),
            ),
            const SizedBox(height: 12),
            IconButton.filledTonal(
              icon: const Icon(Icons.swap_vert),
              tooltip: 'Inverser',
              onPressed: () => setState(() => _usdToHtg = !_usdToHtg),
            ),
            const SizedBox(height: 24),
            Text(
              result == null ? '—' : '${result.toStringAsFixed(2)} $to',
              style: Theme.of(context).textTheme.headlineMedium,
            ),
          ],
        ),
      ),
    );
  }
}
